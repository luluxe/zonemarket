.DEFAULT_GOAL=help

.PHONY: help packer-image terraform-plan terraform-update terraform-destroy

help: ## Display this help screen
	@grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

packer-image: ## Build a new image with packer
	mkdir -p '.build/$(ENV)' && \
	packer build -var-file='./packer/hosts/$(ENV).json' -var 'playbook_ansible=./ansible/playbook.yml' -var 'inventory_directory=./ansible/hosts/$(ENV)' -var 'service_account_json=$(SERVICE_ACCOUNT)' packer/template.json && \
	cat './.build/$(ENV)/manifest.json' | jq -r '.builds[-1].artifact_id' > './.build/$(ENV)/image_family'

terraform-plan: ## Run terraform plan command
	terraform init -input=false -var 'credentials=$(SERVICE_ACCOUNT)' -backend-config='./terraform/hosts/$(ENV)/backend.tfvars' -backend-config='credentials=$(SERVICE_ACCOUNT)' ./terraform && \
	terraform plan -input=false -var-file='./terraform/hosts/$(ENV)/terraform.tfvars' -var 'credentials=$(SERVICE_ACCOUNT)' -var 'image_family='$(shell cat './.build/$(ENV)/image_family') -out='./.build/$(ENV)/tfplan' ./terraform

terraform-update: ## Update the infastructure based on the generated plan
	terraform init -input=false -var 'credentials=$(SERVICE_ACCOUNT)' -backend-config='./terraform/hosts/$(ENV)/backend.tfvars' -backend-config='credentials=$(SERVICE_ACCOUNT)' ./terraform && \
	terraform apply -input=false -auto-approve './.build/$(ENV)/tfplan'

terraform-destroy: ## Destroy the infastructure
	terraform destroy -input=false -auto-approve -force -var-file='./terraform/hosts/$(ENV)/terraform.tfvars' -var 'credentials=$(SERVICE_ACCOUNT)' -var 'image_family='$(shell cat './.build/$(ENV)/image_family') ./terraform
