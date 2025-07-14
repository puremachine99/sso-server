<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoginLogResource\Pages;
use App\Filament\Resources\LoginLogResource\RelationManagers;
use App\Models\LoginLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoginLogResource extends Resource
{
    protected static ?string $model = LoginLog::class;
    protected static ?string $navigationGroup = 'System Logs';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 99;
    public static function canCreate(): bool
    {
        return false;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('login_type')
                    ->label('Login Type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'manual' => 'gray',
                        'oauth' => 'indigo',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('app_code')
                    ->label('App'),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP'),

                Tables\Columns\TextColumn::make('logged_in_at')
                    ->label('Login Time')
                    ->dateTime()
                    ->sortable(),

            ])
            ->defaultSort('logged_in_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLoginLogs::route('/'),
            'create' => Pages\CreateLoginLog::route('/create'),
            'edit' => Pages\EditLoginLog::route('/{record}/edit'),
        ];
    }
}
