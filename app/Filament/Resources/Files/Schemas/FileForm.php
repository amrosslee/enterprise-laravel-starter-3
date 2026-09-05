<?php

namespace App\Filament\Resources\Files\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('project_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('path')
                    ->required(),
            ]);
    }
}
