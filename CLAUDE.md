# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is `integritty/sylius-product-badge-plugin` - a Sylius plugin that adds product badge/label functionality to Sylius e-commerce stores. It allows administrators to create badges and assign them to products for display in both admin and shop interfaces.

## Development Commands

### Docker Environment (Recommended)
```bash
make init              # Initialize Docker, install deps, start containers
make up                # Start containers
make down              # Stop containers
make clean             # Stop containers and remove volumes
make php-shell         # Access PHP container
make node-shell        # Access Node container
make database-init     # Create database and run migrations
make database-reset    # Drop, recreate DB, and run migrations
make load-fixtures     # Load test fixtures
```

### Testing
```bash
# PHPUnit - all tests
vendor/bin/phpunit
make phpunit                          # Docker

# PHPUnit - specific suite
vendor/bin/phpunit --testsuite unit
vendor/bin/phpunit --testsuite functional
vendor/bin/phpunit --testsuite integration

# Behat - non-JS scenarios
vendor/bin/behat --strict --tags="~@javascript&&~@mink:chromedriver"
make behat                            # Docker

# Behat - JS scenarios (requires Chrome headless + symfony server)
APP_ENV=test symfony server:start --port=8080 --daemon
vendor/bin/behat --strict --tags="@javascript,@mink:chromedriver"
```

### Code Quality
```bash
vendor/bin/phpstan analyse -c phpstan.neon -l max src/
vendor/bin/ecs check
make phpstan                          # Docker
make ecs                              # Docker
```

### Traditional Development (without Docker)
```bash
(cd vendor/sylius/test-application && yarn install && yarn build)
vendor/bin/console assets:install
vendor/bin/console doctrine:database:create
vendor/bin/console doctrine:migrations:migrate -n
vendor/bin/console sylius:fixtures:load -n
symfony server:start -d
```

## Architecture

### Plugin Entry Point
- `src/IntegrittySyliusProductBadgePlugin.php` - Bundle class using `SyliusPluginTrait`
- `src/DependencyInjection/IntegrittySyliusProductBadgeExtension.php` - Loads services and registers Doctrine migrations

### Entity Layer
The plugin defines its own entities and provides traits for extending Sylius Product:
- `src/Entity/ProductBadge.php` - Main badge entity (translatable)
- `src/Entity/ProductBadgeTranslation.php` - Badge translations
- `src/Entity/ProductBadgeAwareTrait.php` - Trait for adding badges to Product entity
- `src/Entity/ProductBadgeAwareInterface.php` - Interface for badge-aware products

Doctrine mappings: `config/doctrine/*.orm.xml` (YAML not supported in Doctrine ORM 3.0+)

### Service Configuration
- `config/plugin_services.yaml` - Main plugin service definitions (imports from `config/services/`)
- `config/services/forms.yaml` - Form types
- `config/services/event_listeners.yaml` - Event listeners
- `config/services/component.yaml` - Twig components

### Resource Configuration (Sylius Resource Bundle)
- `config/resources/product_badge.yaml` - CRUD resource definition
- `config/grids/product_badge.yaml` - Admin grid configuration

### Routing
- `config/routes/admin.yaml` - Admin panel routes
- `config/routes/shop.yaml` - Storefront routes
- `config/routes/api_platform.yaml` - REST API routes

### Templates
- `templates/admin/` - Admin interface templates
- `templates/shop/` - Storefront templates
- Twig hooks configuration: `config/app/twig_hooks/`

### Test Application
Uses `sylius/test-application` package for isolated plugin testing:
- Bootstrap: `vendor/sylius/test-application/config/bootstrap.php`
- Kernel: `Sylius\TestApplication\Kernel`
- Environment config: `tests/TestApplication/.env`

## Database Configuration

Configure credentials in:
- `tests/TestApplication/.env` - Development
- `tests/TestApplication/.env.test` - Testing

## AI Development Guides

- **CLEANUP_GUIDE.md** - Code organization guidelines
- **RENAME_GUIDE.md** - Renaming plugin components
- **COMPATIBILITY_GUIDE.md** - Multi-version Sylius compatibility
