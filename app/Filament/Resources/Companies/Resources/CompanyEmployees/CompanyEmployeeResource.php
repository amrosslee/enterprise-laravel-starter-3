<?php

namespace App\Filament\Resources\Companies\Resources\CompanyEmployees;

use App\Filament\Resources\Companies\CompanyResource;
use App\Filament\Resources\Companies\RelationManagers\EmployeesRelationManager;
use App\Filament\Resources\Companies\Resources\CompanyEmployees\Pages\CreateCompanyEmployee;
use App\Filament\Resources\Companies\Resources\CompanyEmployees\Pages\EditCompanyEmployee;
use App\Filament\Resources\Companies\Resources\CompanyEmployees\Pages\ViewCompanyEmployee;
use App\Filament\Resources\Companies\Resources\CompanyEmployees\Schemas\CompanyEmployeeForm;
use App\Filament\Resources\Companies\Resources\CompanyEmployees\Schemas\CompanyEmployeeInfolist;
use App\Filament\Resources\Companies\Resources\CompanyEmployees\Tables\CompanyEmployeesTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyEmployeeResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = CompanyResource::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CompanyEmployeeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CompanyEmployeeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompanyEmployeesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            // 
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateCompanyEmployee::route('/create'),
            'view' => ViewCompanyEmployee::route('/{record}'),
            'edit' => EditCompanyEmployee::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
