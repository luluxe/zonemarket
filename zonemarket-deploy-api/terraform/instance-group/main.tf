terraform {
  required_version = ">= 0.12.2"
}

data "google_compute_image" "web_app_image" {
    name = "${var.image_family}"
}

resource "google_compute_instance_template" "default" {
  name_prefix        = "${var.network_name}-template"

  machine_type         = "${var.machine_type}"
  can_ip_forward       = false

  scheduling {
    automatic_restart   = true
    on_host_maintenance = "MIGRATE"
  }

  disk {
    source_image = "${data.google_compute_image.web_app_image.self_link}"
    auto_delete  = true
    boot         = true
    disk_type    = "pd-ssd"
  }

  network_interface {
    network = "default"

    access_config {
      // Ephemeral IP
    }
  }

  service_account {
    scopes = [
      "userinfo-email", 
      "compute-ro", 
      "storage-rw",
      "sql-admin",
      "datastore", 
      "logging-write",
      "monitoring-write",
      "service-management",
      "service-control",
      "https://www.googleapis.com/auth/trace.append",
      "https://www.googleapis.com/auth/firebase.database",
      "https://www.googleapis.com/auth/cloud-platform",
    ]
  }

  lifecycle {
    create_before_destroy = true
  }
}

resource "google_compute_region_instance_group_manager" "default" {
  provider = "google-beta"

  name               = "${var.network_name}-region-group-manager"
  base_instance_name = "${var.network_name}"
  region             = "${var.region}"

  version {
    name = "main"
    instance_template  = "${google_compute_instance_template.default.self_link}"
  }

  update_policy {
    type = "PROACTIVE"
    minimal_action = "REPLACE"
    max_surge_fixed = 3
    max_unavailable_fixed = 0
    min_ready_sec = 10
  }

  named_port {
    name = "http"
    port = 80
  }
}


resource "google_compute_region_autoscaler" "default" {
  name   = "${var.network_name}-region-autoscaler"
  target = "${google_compute_region_instance_group_manager.default.self_link}"

  autoscaling_policy {
    max_replicas    = 5
    min_replicas    = 1
    cooldown_period = 60

    cpu_utilization {
      target = 0.5
    }
  }
}

resource "google_compute_firewall" "default" {
  name    = "${var.network_name}-firewall"
  network = "default"
  source_ranges = ["130.211.0.0/22", "35.191.0.0/16", "209.85.152.0/22", "209.85.204.0/22", "34.95.106.254"]

  allow {
    protocol = "tcp"
    ports    = ["80"]
  }

  depends_on = ["google_compute_instance_template.default"]
}

resource "google_compute_global_forwarding_rule" "default" {
  name       = "${replace(var.domain_name, ".", "-")}-forwarding-rule"
  target     = "${google_compute_target_https_proxy.default.self_link}"
  port_range = "443"
  ip_address = "${var.ip_address}"
}

resource "google_compute_target_https_proxy" "default" {
  provider = "google-beta"

  name        = "${replace(var.domain_name, ".", "-")}-proxy"
  url_map     = "${google_compute_url_map.default.self_link}"
  ssl_certificates = ["${google_compute_managed_ssl_certificate.default.self_link}"]

  lifecycle {
    ignore_changes = ["ssl_certificates"]
  }
}

resource "google_compute_managed_ssl_certificate" "default" {
  provider = "google-beta"

  name        = "${replace(var.domain_name, ".", "-")}-managed-ssl-cert"

  managed {
    domains = ["${var.domain_name}"]
  }
}

resource "google_compute_url_map" "default" {
  provider = "google-beta"

  name        = "${var.network_name}-urlmap"
  default_service = "${google_compute_backend_service.default.self_link}"

  depends_on = ["google_compute_backend_service.default"]
}

resource "google_compute_backend_service" "default" {
  name        = "${var.network_name}-backend"
  port_name   = "http"
  protocol    = "HTTP"
  timeout_sec = 45

  backend {
    group = "${google_compute_region_instance_group_manager.default.instance_group}"
  }

  health_checks = ["${google_compute_health_check.default.self_link}"]
}

resource "google_compute_health_check" "default" {
  name               = "${var.network_name}-test"
  check_interval_sec = 30
  timeout_sec        = 15

  tcp_health_check {
    port = "80"
  }
}
