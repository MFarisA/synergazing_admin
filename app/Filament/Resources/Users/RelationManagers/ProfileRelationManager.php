<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'profile';

    protected static ?string $title = 'Profile';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Information')
                    ->schema([
                        Textarea::make('about_me')
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull()
                            ->label('About Me'),
                        TextInput::make('location')
                            ->maxLength(255)
                            ->placeholder('e.g., Jakarta, Indonesia'),
                        TextInput::make('academic')
                            ->maxLength(255)
                            ->label('Academic Background')
                            ->placeholder('e.g., Computer Science, MIT'),
                        Textarea::make('interests')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->placeholder('Your interests and hobbies'),
                    ])
                    ->columns(2),

                Section::make('Social Media & Links')
                    ->schema([
                        TextInput::make('website_url')
                            ->url()
                            ->maxLength(255)
                            ->label('Website URL')
                            ->placeholder('https://yourwebsite.com'),
                        TextInput::make('github_url')
                            ->url()
                            ->maxLength(255)
                            ->label('GitHub URL')
                            ->placeholder('https://github.com/username'),
                        TextInput::make('linkedin_url')
                            ->url()
                            ->maxLength(255)
                            ->label('LinkedIn URL')
                            ->placeholder('https://linkedin.com/in/username'),
                        TextInput::make('instagram_url')
                            ->url()
                            ->maxLength(255)
                            ->label('Instagram URL')
                            ->placeholder('https://instagram.com/username'),
                        TextInput::make('portfolio_url')
                            ->url()
                            ->maxLength(255)
                            ->label('Portfolio URL')
                            ->placeholder('https://portfolio.com'),
                    ])
                    ->columns(2),

                Section::make('Files')
                    ->schema([
                        FileUpload::make('profile_picture')
                            ->image()
                            ->directory('profiles')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                            ])
                            ->maxSize(2048)
                            ->label('Profile Picture')
                            ->helperText('Max 2MB. Recommended: Square image (1:1 ratio)')
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png']),
                        FileUpload::make('cv_file')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('cv')
                            ->maxSize(10240)
                            ->label('CV/Resume')
                            ->helperText('Max 10MB. Accepted: PDF only')
                            ->downloadable(),
                    ])
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_picture')
                    ->circular()
                    ->label('Picture')
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                TextColumn::make('location')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('academic')
                    ->label('Academic')
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('about_me')
                    ->label('About')
                    ->limit(50)
                    ->wrap()
                    ->toggleable(),
                TextColumn::make('cv_file')
                    ->label('CV')
                    ->formatStateUsing(fn($state) => $state ? '✓ Uploaded' : '✗ No CV')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'gray'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Create Profile'),
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
