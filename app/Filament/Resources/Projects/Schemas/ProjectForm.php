<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->description('Stage 1: Essential project details')
                    ->schema([
                        Select::make('creator_id')
                            ->relationship('creator', 'name')
                            ->required()
                            ->searchable()
                            ->label('Project Creator'),
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
                            ->required()
                            ->label('Project Type'),
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
                    ->description('Stage 2: Timeline, team size, and logistics')
                    ->schema([
                        TextInput::make('duration')
                            ->maxLength(255)
                            ->placeholder('e.g., 3 months'),
                        TextInput::make('total_team')
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->label('Total Team Size'),
                        DateTimePicker::make('start_date')
                            ->label('Start Date'),
                        DateTimePicker::make('end_date')
                            ->label('End Date'),
                        DateTimePicker::make('registration_deadline')
                            ->label('Registration Deadline'),
                        TextInput::make('location')
                            ->maxLength(255),
                        TextInput::make('budget')
                            ->maxLength(255)
                            ->placeholder('e.g., $5000 or Unpaid'),
                    ])
                    ->columns(2),

                Section::make('Requirements')
                    ->description('Stage 3: Time commitment and conditions')
                    ->schema([
                        TextInput::make('time_commitment')
                            ->maxLength(255)
                            ->placeholder('e.g., 10 hours/week')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Status & Stage')
                    ->description('Project status and completion tracking')
                    ->schema([
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
                        TextInput::make('completion_stage')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5)
                            ->default(0)
                            ->label('Completion Stage (0-5)')
                            ->helperText('0=Not started, 1-4=In progress, 5=Published'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
