<?php

namespace App\Filament\Resources\Projects\Resources\ProjectTasks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProjectTaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'title')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Toggle::make('is_complete')
                    ->required(),
            ]);
    }
}
