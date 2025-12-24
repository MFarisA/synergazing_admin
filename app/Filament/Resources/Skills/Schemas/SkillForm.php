<?php

namespace App\Filament\Resources\Skills\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Select::make('user_id')
                //     ->relationship('users', 'name')
                //     ->required(),
                TextInput::make('name')
                    ->required()
                    ->label('Skill name')
                    ->maxLength(100)
                    ->unique(ignoreRecord: true),
            ]);
    }
}
