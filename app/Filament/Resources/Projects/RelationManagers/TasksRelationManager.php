<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\Projects\Resources\ProjectTasks\ProjectTaskResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    protected static ?string $relatedResource = ProjectTaskResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
