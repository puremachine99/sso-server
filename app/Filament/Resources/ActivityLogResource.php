<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use App\Models\ActivityLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationGroup = 'System Logs';
    protected static ?int $navigationSort = 98;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('event')
                    ->badge()
                    ->color(fn (string $state) => match (true) {
                        Str::startsWith($state, 'auth.login') => 'success',
                        Str::startsWith($state, 'auth.logout') => 'gray',
                        Str::contains($state, 'failed') => 'danger',
                        Str::contains($state, 'password') => 'warning',
                        Str::startsWith($state, 'role.') => 'info',
                        Str::startsWith($state, 'permission.') => 'info',
                        default => 'primary',
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->wrap()
                    ->limit(60)
                    ->searchable(),

                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Causer')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Subject Type')
                    ->toggleable()
                    ->limit(24)
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject_id')
                    ->label('Subject ID')
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('method')
                    ->badge()
                    ->toggleable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('ip')
                    ->label('IP')
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('url')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->url)
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('date')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from'),
                        \Filament\Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'] ?? null, fn($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),

                Tables\Filters\SelectFilter::make('event')
                    ->multiple()
                    ->options([
                        'auth.login' => 'auth.login',
                        'auth.login_failed' => 'auth.login_failed',
                        'auth.logout' => 'auth.logout',
                        'auth.password_reset' => 'auth.password_reset',
                        'user.updated' => 'user.updated',
                        'user.password.updated' => 'user.password.updated',
                        'role.attached' => 'role.attached',
                        'role.detached' => 'role.detached',
                        'permission.attached' => 'permission.attached',
                        'permission.detached' => 'permission.detached',
                    ]),

                Tables\Filters\SelectFilter::make('method')
                    ->multiple()
                    ->options([
                        'GET' => 'GET', 'POST' => 'POST', 'PUT' => 'PUT', 'PATCH' => 'PATCH', 'DELETE' => 'DELETE'
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
            'view' => Pages\ViewActivityLog::route('/{record}'),
        ];
    }
}

