<?php

namespace App\Filament\Resources\Companies\Resources\CompanyEmployees\Pages;

use App\Filament\Resources\Companies\Resources\CompanyEmployees\CompanyEmployeeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCompanyEmployee extends ViewRecord
{
    protected static string $resource = CompanyEmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
