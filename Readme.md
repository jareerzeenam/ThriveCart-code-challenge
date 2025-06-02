# Acme Widget Co

## Description

A Laravel-based basket pricing system that calculates order totals with:

- Tiered delivery pricing (free over $90)
- Special product offers ("Buy 1 Red Widget, get 2nd half price")
- Unit-tested business logic

# Key Components

- BasketService: Core pricing logic

- OfferCalculator: Handles special offers

- DeliveryChargeRule: Manages shipping tiers

## Prerequisites

- Docker & Docker Compose installed
- PHP >= 8.x
- Composer

## Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/jareerzeenam/ThriveCart-code-challenge.git
cd ThriveCart-code-challenge
```

### 2. Docker Setup

### Build and start containers

```bash 
docker compose up -d --build
```

### Install dependencies

```bash 
docker compose exec app composer install
```

### Copy environment file

```bash
docker compose exec app cp .env.example .env
```

### Generate app key

```bash 
docker compose exec app php artisan key:generate
```

### 3. Run Unit Tests

```bash
docker compose exec app php artisan test --filter BasketServiceTest
```

### Run Locally (Without Docker)
```bash
# Clone the repository
composer install

# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Start the local server
php artisan serve

# Run Unit Tests
php artisan test --filter BasketServiceTest
```

# Access the Application

- Web: http://localhost:8080

- MySQL: Port 3307 (optional)

Troubleshooting
If tests fail:

1. Verify containers are running: `docker compose ps`

2. Check logs: `docker compose logs app`

3. Rebuild: `docker compose down && docker compose up -d --build`

Happy coding! 🚀
