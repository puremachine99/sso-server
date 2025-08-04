<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Resources\UserResource\Pages;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Synced User';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = -2;
    protected static string $title = 'Synced and Manual User lists';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::role('super_admin')->count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(fn($record) => $record === null)
                ->visible(fn($record) => $record === null)
                ->default('smartnakama')
                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                ->dehydrated(fn($state) => filled($state)),

            Select::make('roles')
                ->label('Role')
                ->relationship('roles', 'name')
                ->preload()
                ->searchable()
                ->required()
                ->columnSpanFull(),

            Hidden::make('source')->default('manual'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->limit(25),
                TextColumn::make('email')->searchable(),

                TextColumn::make('roles')
                    ->label('Roles')
                    ->getStateUsing(function ($record) {
                        return $record->roles->pluck('name')->implode(', ');
                    })
                    ->searchable(),

                BadgeColumn::make('source')
                    ->label('Acc Type')
                    ->getStateUsing(
                        fn($record) => match ($record->source) {
                            'synced user' => 'Synced User',
                            'manual' => 'Manual',
                            default => 'Unkonwn',
                        }
                    )
                    ->colors([
                        'success' => 'Synced User', // ✅ Ijo
                        'warning' => 'Manual',       // ✅ Kuning
                        'gray' => 'Unknown', // Opsional (jika source null atau typo)
                    ]),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y, H:i'),
            ])
            ->filters([
                SelectFilter::make('source')
                    ->label('Account Type')
                    ->options([
                        'portal' => 'Manual',
                        'synced user' => 'Synced User',
                    ]),

                SelectFilter::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\Action::make('grantSuperadmin')
                    ->label('Grant Superadmin')
                    ->icon('heroicon-o-key')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn($record) => !$record->hasRole('super_admin'))
                    ->action(fn($record) => $record->assignRole('super_admin'))
                    ->after(
                        fn($record) => Notification::make()
                            ->title('Role Granted')
                            ->body("{$record->name} is now a Superadmin.")
                            ->success()
                            ->send()
                    ),

                Tables\Actions\Action::make('revokeSuperadmin')
                    ->label('Revoke Superadmin')
                    ->icon('heroicon-o-lock-closed')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->hasRole('super_admin'))
                    ->action(fn($record) => $record->removeRole('super_admin'))
                    ->after(
                        fn($record) => Notification::make()
                            ->title('Role Revoked')
                            ->body("Superadmin role removed from {$record->name}.")
                            ->warning()
                            ->send()
                    ),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
