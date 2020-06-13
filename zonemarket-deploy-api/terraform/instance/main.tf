terraform {
  required_version = ">= 0.11.6"
}

data "google_compute_image" "web_app_image" {
    name = "${var.image_family}"
}

resource "google_compute_instance" "web" {
  name         = "${var.instance_name}"
  machine_type = "${var.machine_type}"
  zone         = "${var.zone}"

  boot_disk {
    initialize_params {
      image = "${data.google_compute_image.web_app_image.self_link}"
    }
  }

  network_interface {
    network = "default"

    access_config {
      // Ephemeral IP
    }
  }
}

resource "google_compute_firewall" "web" {
  name = "web-firewall"

  network = "default"

  allow {
    protocol = "tcp"
    ports = ["80", "443"]
  }
}
