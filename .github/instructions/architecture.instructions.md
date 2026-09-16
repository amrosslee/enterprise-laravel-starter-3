# Enterprise Laravel Architecture Pattern

Apply to: `**/*.php` (all PHP files in the project)

Use when: creating models, repositories, services, controllers, or request classes.

---

## Architecture Overview

This project follows a **strict 3-layer architecture pattern** combining **Repository Pattern**, **Service Layer**, and **Form Request validation groups**. All agents must follow this structure when generating code.

### Layer Structure

```
Models/Product
├── Repositories/
│   ├── Contracts/ProductRepositoryContract.php (interface)
│   └── Eloquent/ProductEloquentRepository.php (implementation)
├── Services/ProductService.php (business logic)
├── Http/
│   ├── Controllers/ProductController.php
│   └── Requests/Product/
│       ├── StoreProductRequest.php
│       └── UpdateProductRequest.php
└── Models/Product.php
```

---

## 1. Repository Pattern (Contracts + Eloquent)

### Directory Structure
- `app/Repositories/Contracts/` — All repository interfaces
- `app/Repositories/Eloquent/` — All Eloquent implementations

### Creating a Repository Contract (Interface)

**File:** `app/Repositories/Contracts/ProductRepositoryContract.php`

```php
<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\Paginator;

interface ProductRepositoryContract
{
    public function getAll(): array;

    public function paginate(int $perPage = 15): Paginator;

    public function find(int $id): ?object;

    public function create(array $data): object;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
```

**Key Rules:**
- Use descriptive return types: `?object`, `array`, `Paginator`, `Collection`
- Use explicit parameter type hints
- No implementation—only method signatures and PHPDoc blocks
- One contract per model

### Creating an Eloquent Repository (Implementation)

**File:** `app/Repositories/Eloquent/ProductEloquentRepository.php`

```php
<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;
use Illuminate\Pagination\Paginator;

class ProductEloquentRepository implements ProductRepositoryContract
{
    public function __construct(private Product $product) {}

    public function getAll(): array
    {
        return $this->product->all()->toArray();
    }

    public function paginate(int $perPage = 15): Paginator
    {
        return $this->product->paginate($perPage);
    }

    public function find(int $id): ?object
    {
        return $this->product->find($id);
    }

    public function create(array $data): object
    {
        return $this->product->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->product->find($id)?->update($data) ?? false;
    }

    public function delete(int $id): bool
    {
        return $this->product->find($id)?->delete() ?? false;
    }
}
```

**Key Rules:**
- Constructor dependency injection via property promotion
- Implement the corresponding Contract
- All database queries use Eloquent models
- Return types match the Contract exactly
- Keep logic simple—complex business logic goes in Services

### Repository Registration

Add to `app/Providers/RepositoryServiceProvider.php`:

```php
$this->app->bind(
    ProductRepositoryContract::class,
    ProductEloquentRepository::class,
);
```

---

## 2. Service Layer

**File:** `app/Services/ProductService.php`

```php
<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryContract;

class ProductService
{
    public function __construct(private ProductRepositoryContract $productRepository) {}

    /**
     * Create a new product with related data
     *
     * @param  array<string, mixed>  $data
     */
    public function createWithRelations(array $data): object
    {
        $product = $this->productRepository->create($data);

        if (isset($data['categories'])) {
            $product->categories()->sync($data['categories']);
        }

        return $product->fresh();
    }

    /**
     * Update a product with validation checks
     *
     * @param  array<string, mixed>  $data
     */
    public function updateWithValidation(int $id, array $data): bool
    {
        $product = $this->productRepository->find($id);

        if (! $product) {
            return false;
        }

        return $this->productRepository->update($id, $data);
    }

    public function deactivateProduct(int $id): bool
    {
        return $this->productRepository->update($id, ['is_active' => false]);
    }
}
```

**Key Rules:**
- Inject repository via constructor dependency injection
- Services contain **business logic**, not database queries
- Services handle **relationships, transactions, validation workflow**
- All database access goes through repositories (never direct queries)
- Use descriptive method names in gerund form: `createWithRelations`, not `create`
- Use PHPDoc for array shapes: `@param array<string, mixed> $data`

---

## 3. Form Requests (Grouped by Model)

### Directory Structure
```
app/Http/Requests/
├── Product/
│   ├── StoreProductRequest.php
│   ├── UpdateProductRequest.php
│   └── BulkDeleteProductRequest.php
├── Company/
│   ├── StoreCompanyRequest.php
│   └── UpdateCompanyRequest.php
```

**File:** `app/Http/Requests/Product/StoreProductRequest.php`

```php
<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Product::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:products'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'gt:0'],
            'sku' => ['required', 'string', 'unique:products'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['integer', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'A product with this name already exists.',
            'categories.min' => 'Select at least one category.',
        ];
    }
}
```

**File:** `app/Http/Requests/Product/UpdateProductRequest.php`

```php
<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->product) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($this->product)],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'gt:0'],
            'sku' => ['required', 'string', Rule::unique('products')->ignore($this->product)],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['integer', 'exists:categories,id'],
        ];
    }
}
```

**Key Rules:**
- Group requests by model name in a subfolder: `Product/`, `Company/`, etc.
- Use authorization gates/policies: `$this->user()?->can('create', Model::class)`
- Use explicit rule arrays: `['required', 'string', 'max:255']`
- Use `Rule::unique()` with `.ignore()` for updates
- Add `messages()` method for custom error messages
- Do NOT include business logic in requests (validation only)

---

## 4. Controllers

**File:** `app/Http/Controllers/ProductController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index(): Response
    {
        return Inertia::render('Products/Index', [
            'products' => Product::paginate(15),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Products/Create');
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createWithRelations($request->validated());

        return redirect()->route('products.show', $product)
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): Response
    {
        return Inertia::render('Products/Edit', ['product' => $product]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productService->updateWithValidation($product->id, $request->validated());

        return redirect()->route('products.show', $product)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->productService->deactivateProduct($product->id);

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
```

**Key Rules:**
- Inject services via constructor
- Use validated form requests: `$request->validated()`
- Delegate business logic to services
- Controllers are thin—orchestrate, don't compute
- Use Inertia for responses: `Inertia::render()`
- Use implicit route model binding: `Product $product`

---

## 5. Models

**File:** `app/Models/Product.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'sku', 'is_active'];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
```

**Key Rules:**
- Define `$fillable` for mass assignment
- Use `$casts` for type safety
- Define all relationships
- Keep models focused on data structure and relationships
- No business logic in models (use Services)

---

## File Creation Checklist

When creating a new model feature, **always create these files in this order**:

1. ✅ Migration: `database/migrations/YYYY_MM_DD_HHMMSS_create_products_table.php`
2. ✅ Model: `app/Models/Product.php`
3. ✅ Factory: `database/factories/ProductFactory.php`
4. ✅ Repository Contract: `app/Repositories/Contracts/ProductRepositoryContract.php`
5. ✅ Repository Implementation: `app/Repositories/Eloquent/ProductEloquentRepository.php`
6. ✅ Service: `app/Services/ProductService.php`
7. ✅ Form Requests:
   - `app/Http/Requests/Product/StoreProductRequest.php`
   - `app/Http/Requests/Product/UpdateProductRequest.php`
8. ✅ Controller: `app/Http/Controllers/ProductController.php`
9. ✅ Tests: `tests/Feature/ProductControllerTest.php`
10. ✅ Routes: Register in `routes/web.php` or `routes/api.php`

---

## Dependency Injection in Service Provider

Add to `app/Providers/AppServiceProvider.php` or create `app/Providers/RepositoryServiceProvider.php`:

```php
<?php

namespace App\Providers;

use App\Repositories\Contracts\ProductRepositoryContract;
use App\Repositories\Eloquent\ProductEloquentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepositoryContract::class, ProductEloquentRepository::class);
        $this->app->bind(CompanyRepositoryContract::class, CompanyEloquentRepository::class);
        // Add more bindings as you create repositories
    }
}
```

Register in `config/app.php` under `providers` array.

---

## Testing

Every controller, service, and repository needs tests. Use Pest:

```php
<?php

use App\Models\Product;
use App\Services\ProductService;

it('creates a product with relations', function () {
    $service = app(ProductService::class);
    
    $product = $service->createWithRelations([
        'name' => 'Test Product',
        'price' => 99.99,
        'categories' => [1, 2],
    ]);

    expect($product)->toBeInstanceOf(Product::class);
    expect($product->categories)->toHaveCount(2);
});
```

---

## Important Rules for All Agents

1. **Never skip the repository layer** — always use contracts + implementations
2. **Never put business logic in controllers** — delegate to services
3. **Never query directly in controllers** — use repositories
4. **Always group form requests by model** in subdirectories
5. **Always use dependency injection** — constructor property promotion
6. **Always run tests** after creating features: `php artisan test --filter=ProductControllerTest`
7. **Always format with Pint**: `vendor/bin/pint --dirty` before finalizing
8. **Always use Inertia::render()** for frontend responses, not Blade

---

## Quick Commands

```bash
# Create all model files at once
php artisan make:model Product -mfcsrp

# Create repository contract
php artisan make:class Repositories/Contracts/ProductRepositoryContract

# Create repository implementation  
php artisan make:class Repositories/Eloquent/ProductEloquentRepository

# Create service
php artisan make:class Services/ProductService

# Create grouped form requests
php artisan make:request Product/StoreProductRequest
php artisan make:request Product/UpdateProductRequest

# Create controller
php artisan make:controller ProductController -r

# Create test
php artisan make:test Feature/ProductControllerTest --pest

# Format code
vendor/bin/pint --dirty --format agent
```
