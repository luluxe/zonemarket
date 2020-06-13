terraform {
  required_version = ">= 0.12.2"
  backend "gcs" {}
}

provider "google" {
  credentials = "${file("${var.credentials}")}"
  project     = "${var.project_id}"
  region      = "${var.region}"
  version     = "~> 2.5"
}

provider "google-beta" {
  credentials = "${file("${var.credentials}")}"
  project     = "${var.project_id}"
  region      = "${var.region}"
  version     = "~> 2.9"
}


/*module "instance" {
  source = "./instance"

  instance_name = "${var.instance_name}"
  machine_type = "${var.machine_type}"
  zone = "${var.zone}"
  image_family = "${var.image_family}"
}

output "vm_ip" {
  value = "${module.instance.static_ip}"
}*/


module "instance-group" {
  source = "./instance-group"

  zone = "${var.zone}"
  network_name = "${var.instance_name}"
  machine_type = "${var.machine_type}"
  image_family = "${var.image_family}"
  domain_name = "${var.domain_name}"
}

output "lb-ip" {
  value = "${module.instance-group.external_ip}"
}
