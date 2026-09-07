<?php

namespace App\Filament\Resources\Companies\Resources\CompanyEmployees\Pages;

use App\Filament\Resources\Companies\Resources\CompanyEmployees\CompanyEmployeeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCompanyEmployee extends EditRecord
{
    protected static string $resource = CompanyEmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
