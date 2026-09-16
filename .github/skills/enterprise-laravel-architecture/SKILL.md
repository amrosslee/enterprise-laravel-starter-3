---
name: enterprise-laravel-architecture
description: Generate complete Laravel models following enterprise 3-layer architecture with repositories, services, form requests, controllers, and tests.
---

# Enterprise Laravel Architecture Skill

## When to Use

Activate this skill whenever you need to **create a new model, repository, service, controller, or form requests** in this project. The skill ensures all code follows the enterprise architecture pattern.

## What You Get

This skill automatically guides generation of:

- **Repositories** (Contracts + Eloquent implementations)
- **Services** (business logic layer)
- **Form Requests** (grouped by model in subfolders)
- **Controllers** (thin, orchestration-only)
- **Tests** (Pest test suite)
- **Migrations, Models, Factories**

## Architecture Pattern

```
App/Models/Product
├── Repositories/Contracts/ProductRepositoryContract.php (interface)
├── Repositories/Eloquent/ProductEloquentRepository.php (implementation)
├── Services/ProductService.php (business logic)
├── Http/Controllers/ProductController.php
└── Http/Requests/Product/
    ├── StoreProductRequest.php
    └── UpdateProductRequest.php
```

## Key Rules (Always Follow)

1. **Repository Pattern**: Every model gets a Contract + Eloquent implementation
2. **Service Layer**: All business logic lives in services, NOT controllers
3. **Form Requests**: Grouped by model in subdirectories (Product/, Company/, etc)
4. **Dependency Injection**: Always use constructor property promotion
5. **Type Hints**: Full type hints + PHPDoc blocks on all methods
6. **Authorization**: Always check `$this->user()?->can()` in requests
7. **Tests**: Write Pest tests immediately after code
8. **Pint Formatting**: Always run `vendor/bin/pint --dirty` before finalizing

## Quick Start

Tell me:
1. Model name (e.g., "Product", "BlogPost")
2. Fields (e.g., "name:string, price:decimal:8:2, is_active:boolean")
3. Relationships (e.g., "belongsTo:Company, hasMany:Order")
4. API or Web forms

I'll generate the entire stack!

## File Checklist

When creating a feature:
- [ ] Migration
- [ ] Model with relationships and casts
- [ ] Factory
- [ ] Repository Contract
- [ ] Repository Implementation
- [ ] Service with business logic
- [ ] Store Form Request
- [ ] Update Form Request
- [ ] Controller (resource methods)
- [ ] Feature tests with Pest
- [ ] Routes
- [ ] Service Provider binding

## Example

```bash
# I generate all of this for you:
php artisan make:model Product -mfcsrp
php artisan make:class Repositories/Contracts/ProductRepositoryContract
php artisan make:class Repositories/Eloquent/ProductEloquentRepository
php artisan make:class Services/ProductService
php artisan make:request Product/StoreProductRequest
php artisan make:request Product/UpdateProductRequest
php artisan make:controller ProductController -r
php artisan make:test Feature/ProductControllerTest --pest
vendor/bin/pint --dirty
php artisan test
```

See `.github/instructions/architecture.instructions.md` for complete detailed patterns.
