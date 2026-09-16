# Enterprise Laravel Architecture - Setup Complete ✅

Your project is now configured with enterprise architecture guidelines that will guide all AI agents.

## What's Set Up

### 1. **Architecture Instructions** (.github/instructions/architecture.instructions.md)
- **Applies to**: All PHP files in the project
- **Auto-loads**: Whenever you ask an agent to create models, services, repositories, controllers, or requests
- **Contains**: Complete 3-layer architecture pattern with examples and checklist

### 2. **Enterprise Architecture Skill** (.github/skills/enterprise-laravel-architecture/SKILL.md)
- **Activates when**: You specifically mention creating models or features
- **Does**: Provides focused guidance on the full model generation stack
- **How to use**: Ask an agent to "create a Product model" and mention the architecture

## Your Architecture Pattern

Every new model follows this structure:

```
App/Models/Product
├── app/Repositories/Contracts/ProductRepositoryContract.php (interface)
├── app/Repositories/Eloquent/ProductEloquentRepository.php (implementation)
├── app/Services/ProductService.php (business logic)
├── app/Http/Controllers/ProductController.php
├── app/Http/Requests/Product/StoreProductRequest.php
├── app/Http/Requests/Product/UpdateProductRequest.php
├── database/factories/ProductFactory.php
├── database/migrations/...create_products_table.php
└── tests/Feature/ProductControllerTest.php
```

## How to Create a New Model

Just ask any AI agent:

> "Create a new model called `Product` with fields: name:string, description:text, price:decimal:8:2, is_active:boolean. It hasMany Orders and belongsTo Company. Create the full stack following our enterprise architecture."

The agent will:
1. ✅ Create the migration
2. ✅ Create the model with relationships
3. ✅ Create the repository contract
4. ✅ Create the Eloquent repository
5. ✅ Create the service
6. ✅ Create grouped form requests
7. ✅ Create the controller
8. ✅ Create feature tests
9. ✅ Run Pint formatting
10. ✅ Suggest routes to add

## Key Rules (Enforced)

1. **Repository Contracts First** - No direct model queries from controllers
2. **Services for Business Logic** - Not controllers
3. **Grouped Form Requests** - In subfolders by model name
4. **Constructor Injection** - Property promotion always
5. **Full Type Hints** - On all methods
6. **Authorization Checks** - In every request
7. **Tests Required** - Pest tests for all features
8. **Pint Formatting** - Always before completion

## Files to Reference

| File | Purpose |
|------|---------|
| `.github/instructions/architecture.instructions.md` | Complete architecture guide with examples |
| `.github/skills/enterprise-laravel-architecture/SKILL.md` | Model generation skill |
| `app/Repositories/Contracts/` | Repository interfaces |
| `app/Repositories/Eloquent/` | Repository implementations |
| `app/Services/` | Business logic services |
| `app/Http/Requests/` | Grouped form requests by model |

## Next Steps

1. **Test it out**: Ask an agent to create a test model
2. **Customize**: Add more rules to `.github/instructions/architecture.instructions.md` if needed
3. **Add to git**: Commit these files so your team has them
4. **Use it**: Every new feature will follow this pattern

## Quick Commands

```bash
# Format all PHP files with Pint
vendor/bin/pint --dirty

# Run tests
php artisan test --compact

# Create a new model (full stack)
php artisan make:model Product -mfcsrp
php artisan make:class Repositories/Contracts/ProductRepositoryContract
php artisan make:class Repositories/Eloquent/ProductEloquentRepository
php artisan make:class Services/ProductService
php artisan make:request Product/StoreProductRequest
php artisan make:request Product/UpdateProductRequest
php artisan make:controller ProductController -r
php artisan make:test Feature/ProductControllerTest --pest
```

---

**Your agents are now configured to build features the right way, every time! 🚀**
