# Sample project for full deployment on GCP

## Requirements

### Install JQ
Before starting you should install `jq` on your system. It will allow you to parse JSON and extract data from it. You can install it on Ubuntu with the following command : 

```
sudo apt-get install jq
```

### Packer and Terraform
You also have to install Ansible, Packer and Terraform on your system :
* https://docs.ansible.com/ansible/latest/installation_guide/intro_installation.html#latest-releases-via-apt-ubuntu
* https://www.packer.io/downloads.html
* https://www.terraform.io/downloads.html

### Remote state
Create a bucket with the same name as the value you set for the variable `bucket` in the file `terraform/backend.tfvars`. 

It will allow our Terraform configuration to have a remote state : https://www.terraform.io/docs/state/index.html.

## Build an image with Packer & Ansible

Packer will use the Ansible playbook for generating a new image. 

* First copy `packer/variables.json.example` to `packer/variables.json`. 
* Configure that variables file with your own environment variable. 
* Then you can launch the Packer build with the following command : 

```
cd packer
packer build -var-file=variables.json -var 'playbook_ansible=../ansible/playbook.yml' -var 'inventory_directory=../ansible/hosts/prod' template.json
cat manifest.json | jq -r '.builds[-1].artifact_id' > '../terraform/image_family'
```

*Don't forget to define the path to your service account in the file : `packer/variables.json`, in a key named `service_account_json`. Or by adding a `-var` parameter.*

## Create infrastructure with Terraform

Terraform is used to deploy all tools that will form the infrastructure of the project.

* Copy `terraform/terraform.tfvars.example` to `terraform/terraform.tfvars`.
* Configure that variables file with your own environment variable. 
* You can launch the Terraform initalizaion process with the following command : 

```
cd terraform
terraform init -backend-config='./backend.tfvars' ./
```

* After that, you must create a plan file that will be used to create or detroy the resources :

```
terraform plan -var 'image_family='$(cat './image_family') -var-file='./terraform.tfvars' -out='tfplan' ./
```

* Then you can commit the changes with the following command : 

```
terraform apply 'tfplan'
```

* You can get the IP address of the created frontend with the command : 
```
cd terraform
terraform output lb_ip
```

* If needed you can destroy all the created resource with the following command : 
```
 terraform destroy -var 'image_family='(cat './image_family')
```

## Using the Makefile

You can also use the existing Makefile to launch the different commands. The `make` command make it easier when you want to automate the full process, like in a CI job for example.

All the generated files are stored in the `.build` directory.

The service account is defined as parameter of each command. But you can also define it as environment variable and it will work the same.

You can display the list of existing command by running this :

```
make help
```

### Build the packer image

```
make packer-image SERVICE_ACCOUNT='.gcloud/service-account.json'
```

### Create Terraform plan

```
make terraform-plan SERVICE_ACCOUNT='.gcloud/service-account.json'
```

### Update infrastructure

```
make terraform-update SERVICE_ACCOUNT='.gcloud/service-account.json'
```

### Destroy the infrastructure

**This action is auto-approved. Be very careful when running this command.**

```
make terraform-destroy SERVICE_ACCOUNT='.gcloud/service-account.json'
```
