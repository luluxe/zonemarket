terraform {
  required_version = ">= 0.11.6"
}

resource "google_dns_record_set" "web" {
  name = "${data.google_dns_managed_zone.main.dns_name}"
  type = "A"
  ttl  = 60

  managed_zone = "${data.google_dns_managed_zone.main.name}"

  rrdatas = ["${data.google_compute_instance.web.network_interface.0.access_config.0.assigned_nat_ip}"]
}

resource "google_dns_managed_zone" "main" {
  name     = "${var.dns_zone_name}"
  dns_name = "${var.domain_name}."
}