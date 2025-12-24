<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Select::make('project_type')
                            ->options([
                                'research' => 'Research',
                                'development' => 'Development',
                                'design' => 'Design',
                                'marketing' => 'Marketing',
                                'other' => 'Other',
                            ])
                            ->required(),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'ongoing' => 'Ongoing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('draft'),
                        Textarea::make('description')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        FileUpload::make('picture_url')
                            ->image()
                            ->directory('posts')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                            ->label('Project Picture')
                            ->helperText('Max 2MB. Accepted: JPG, JPEG, PNG')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Project Details')
                    ->schema([
                        TextInput::make('duration')
                            ->maxLength(255),
                        TextInput::make('total_team')
                            ->numeric()
                            ->minValue(1),
                        DateTimePicker::make('start_date'),
                        DateTimePicker::make('end_date'),
                        DateTimePicker::make('registration_deadline'),
                        TextInput::make('location')
                            ->maxLength(255),
                        TextInput::make('budget')
                            ->maxLength(255),
                        TextInput::make('time_commitment')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Status')
                    ->schema([
                        TextInput::make('completion_stage')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5)
                            ->default(0)
                            ->label('Completion Stage (0-5)'),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                ImageColumn::make('picture_url')
                    ->label('Picture')
                    ->square()
                    ->defaultImageUrl(url('/images/default-project.png')),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->wrap(),
                TextColumn::make('project_type')
                    ->badge()
                    ->colors([
                        'primary' => 'research',
                        'success' => 'development',
                        'warning' => 'design',
                        'danger' => 'marketing',
                        'secondary' => 'other',
                    ])
                    ->label('Type'),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                        'primary' => 'ongoing',
                        'warning' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                TextColumn::make('completion_stage')
                    ->badge()
                    ->color(fn(int $state): string => match ($state) {
                        0 => 'gray',
                        1, 2, 3, 4 => 'warning',
                        5 => 'success',
                        default => 'gray',
                    })
                    ->label('Stage'),
                TextColumn::make('total_team')
                    ->numeric()
                    ->sortable()
                    ->label('Team'),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('registration_deadline')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
