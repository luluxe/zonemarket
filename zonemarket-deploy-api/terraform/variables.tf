variable "project_id" {
  type = "string"
  description = "The ID of your project."
  default = "zonemarket-prod"
}

variable "region" {
  type = "string"
  description = "The region of your project, e.g. europe-west1."
  default = "europe-west1"
}

variable "credentials" {
  type = "string"
  description = "The path to the json containing your credentials."
  default = ".gcloud/service-account.json"
}

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

variable "domain_name" {
  type = "string"
  description = "domain name"
  default = "zonemarket.frenchsky.ovh"
}
