<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    protected static ?string $title = 'Team Members';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->label('User'),
                Select::make('project_role_id')
                    ->relationship('projectRole', 'name')
                    ->required()
                    ->searchable()
                    ->label('Role'),
                Select::make('status')
                    ->options([
                        'invited' => 'Invited',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->required()
                    ->default('invited'),
                Textarea::make('role_description')
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull()
                    ->label('Role Description'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Member'),
                TextColumn::make('user.email')
                    ->searchable()
                    ->label('Email')
                    ->toggleable(),
                TextColumn::make('projectRole.name')
                    ->searchable()
                    ->sortable()
                    ->label('Role'),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'invited',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                        'primary' => 'active',
                        'secondary' => 'inactive',
                    ]),
                TextColumn::make('role_description')
                    ->limit(50)
                    ->wrap()
                    ->toggleable(),
                TextColumn::make('memberSkills_count')
                    ->counts('memberSkills')
                    ->label('Skills'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'invited' => 'Invited',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Member'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
