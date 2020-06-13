variable "instance_name" {
  type = "string"
  description = "Name of the instance."
  default = "zonemarket-api"
}

variable "machine_type" {
  type = "string"
  description = "The machine type used on GCP, e.g. n1-standard-1"
  default = "g1-small"
}

variable "zone" {
  type = "string"
  description = "Zone of the instance, e.g. europe-west1-b"
  default = "europe-west1-b"
}

variable "image_family" {
  type = "string"
  description = "Name of the image family. By default, it will retrieve the latest image from the family."
  default = "ubuntu-1804-lts"
}
