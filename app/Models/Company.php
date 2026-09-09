<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'logo'])]
class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory, SoftDeletes;

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function logo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? ( strpos($value, 'http') !== false ? $value : asset("storage/" . $value)) : null,
        );
    }
}
