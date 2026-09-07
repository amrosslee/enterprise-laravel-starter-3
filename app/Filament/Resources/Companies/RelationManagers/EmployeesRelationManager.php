<?php

namespace App\Filament\Resources\Companies\RelationManagers;

use App\Filament\Resources\Companies\Resources\CompanyEmployees\CompanyEmployeeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    protected static ?string $relatedResource = CompanyEmployeeResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
