.PHONY: help install start stop restart build migrate seed swagger test clear cache-clear route-clear config-clear view-clear optimize

# Default target
help:
	@echo "Available commands:"
	@echo "  make install     - Install dependencies and set up the project"
	@echo "  make start      - Start the Laravel development server"
	@echo "  make stop       - Stop the Laravel development server"
	@echo "  make restart    - Restart the Laravel development server"
	@echo "  make build      - Build the project (npm install && npm run dev)"
	@echo "  make migrate    - Run database migrations"
	@echo "  make seed       - Run database seeders"
	@echo "  make swagger    - Generate Swagger API documentation"
	@echo "  make test       - Run PHPUnit tests"
	@echo "  make clear      - Clear all caches"
	@echo "  make optimize   - Cache routes, config and optimize the application"

# Installation and setup
install:
	composer install
	cp .env.example .env
	php artisan key:generate
	php artisan storage:link
	npm install
	npm run dev

# Server management
start:
	php artisan serve

stop:
	@pkill -f "php artisan serve" || true

restart: stop start

# Build assets
build:
	npm install
	npm run dev

# Database commands
migrate:
	php artisan migrate

seed:
	php artisan db:seed

fresh:
	php artisan migrate:fresh --seed

# Generate Swagger documentation
swagger:
	php artisan l5-swagger:generate

# Testing
test:
	php artisan test

# Cache management
clear: cache-clear route-clear config-clear view-clear

cache-clear:
	php artisan cache:clear

route-clear:
	php artisan route:clear

config-clear:
	php artisan config:clear

view-clear:
	php artisan view:clear

# Optimization
optimize:
	php artisan config:cache
	php artisan route:cache
	php artisan view:cache
	php artisan optimize

# Docker commands (if using Docker)
docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-build:
	docker-compose build

docker-logs:
	docker-compose logs -f

# Development helpers
ide-helper:
	php artisan ide-helper:generate
	php artisan ide-helper:models -N
	php artisan ide-helper:meta