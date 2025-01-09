laravel-new:
	@if [ -z "$(PROJECT_NAME)" ]; then \
		read -p "Enter project name: " PROJECT_NAME; \
	fi; \
	composer create-project --prefer-dist laravel/laravel $$PROJECT_NAME