<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                TextColumn::make('creator.name')
                    ->searchable()
                    ->sortable()
                    ->label('Creator'),
                BadgeColumn::make('project_type')
                    ->colors([
                        'primary' => 'research',
                        'success' => 'development',
                        'warning' => 'design',
                        'danger' => 'marketing',
                        'secondary' => 'other',
                    ])
                    ->label('Type'),
                BadgeColumn::make('status')
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
                    ->sortable()
                    ->label('Stage'),
                TextColumn::make('total_team')
                    ->numeric()
                    ->sortable()
                    ->label('Team Size'),
                TextColumn::make('members_count')
                    ->counts('members')
                    ->label('Members')
                    ->sortable(),
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
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('project_type')
                    ->options([
                        'research' => 'Research',
                        'development' => 'Development',
                        'design' => 'Design',
                        'marketing' => 'Marketing',
                        'other' => 'Other',
                    ])
                    ->label('Type'),
                SelectFilter::make('completion_stage')
                    ->options([
                        0 => 'Not Started (0)',
                        1 => 'Stage 1',
                        2 => 'Stage 2',
                        3 => 'Stage 3',
                        4 => 'Stage 4',
                        5 => 'Published (5)',
                    ])
                    ->label('Stage'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
