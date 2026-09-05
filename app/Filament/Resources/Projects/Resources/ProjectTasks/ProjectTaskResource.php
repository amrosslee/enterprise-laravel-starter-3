<?php

namespace App\Filament\Resources\Projects\Resources\ProjectTasks;

use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Projects\Resources\ProjectTasks\Pages\CreateProjectTask;
use App\Filament\Resources\Projects\Resources\ProjectTasks\Pages\EditProjectTask;
use App\Filament\Resources\Projects\Resources\ProjectTasks\Pages\ViewProjectTask;
use App\Filament\Resources\Projects\Resources\ProjectTasks\Schemas\ProjectTaskForm;
use App\Filament\Resources\Projects\Resources\ProjectTasks\Schemas\ProjectTaskInfolist;
use App\Filament\Resources\Projects\Resources\ProjectTasks\Tables\ProjectTasksTable;
use App\Models\Task;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectTaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = ProjectResource::class;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ProjectTaskForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProjectTaskInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectTasksTable::configure($table);
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
            'create' => CreateProjectTask::route('/create'),
            'view' => ViewProjectTask::route('/{record}'),
            'edit' => EditProjectTask::route('/{record}/edit'),
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
