variable "network_name" {
  type = "string"
  description = "Name of the network."
  default = "zonemarket-prod"
}

variable "ip_address" {
  type = "string"
  description = "The ip of the load balancing"
  default = "34.95.106.254"
}

variable "machine_type" {
  type = "string"
  description = "The machine type used on GCP, e.g. n1-standard-1"
  default = "g1-small"
}

variable "image_family" {
  type = "string"
  description = "Name of the image family. By default, it will retrieve the latest image from the family."
  default = "ubuntu-1804-lts"
}

variable "region" {
  type = "string"
  description = "The region of your project, e.g. europe-west1."
  default = "europe-west1"
}

variable "zone" {
  type = "string"
  description = "Zone of the instance, e.g. europe-west1-b"
  default = "europe-west1-b"
}

variable "domain_name" {
  type = "string"
  description = "domain name used for generating the ssl certificate"
  default = "zonemarket.frenchsky.ovh"
}
