<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
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
                Toggle::make('is_email_verified')
                    ->required(),
                TextInput::make('phone')
                    ->required()
                    ->label('Phone number'),
                Select::make('status_collaboration')
                    ->options([
                        'ready' => 'Ready',
                        'not ready' => 'Not Ready',
                    ])
                    ->required()
                    ->label('Status collaboration'),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }
}
