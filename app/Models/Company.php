<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
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
}
