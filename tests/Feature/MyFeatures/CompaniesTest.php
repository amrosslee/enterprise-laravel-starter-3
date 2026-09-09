<?php

use App\Filament\Resources\Comments\Pages\CreateComment;
use App\Filament\Resources\Companies\Pages\CreateCompany;
use App\Filament\Resources\Companies\Pages\EditCompany;
use App\Filament\Resources\Companies\Pages\ListCompanies;
use App\Http\Controllers\CompanyController;
use App\Models\Company;
use App\Models\User;
use Livewire\Livewire;


it('list companies', function () {
    $companies = Company::factory()->count(5)->create();
    $user = User::factory()->create();

    Livewire::actingAs($user)
    ->test(ListCompanies::class)
    ->assertOk()
    ->assertCanSeeTableRecords($companies);
});

it('create a company', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateCompany::class)
        ->assertOk();
});

it('edit-company', function () {
    $user = User::factory()->create();
    $company = Company::factory()->create();
    Livewire::actingAs($user)
        ->test(EditCompany::class, [
            'record' => $company->id,
        ])
        ->assertOk()
        ->assertSchemaStateSet([
            'name' => $company->name,
            // 'logo' => $company->logo,
        ]);
});

