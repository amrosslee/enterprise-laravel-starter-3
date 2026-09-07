<?php

namespace App\Filament\Resources\Companies\Resources\CompanyEmployees\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CompanyEmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                // DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('password_confirmation')
                    ->password()
                    ->same('password')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
