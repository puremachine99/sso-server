<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Grant';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 10;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::role('super_admin')->count();
    }
    public static function form(Forms\Form $form): Forms\Form
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
                ->default('smartnakama25!!')
                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                ->dehydrated(fn($state) => filled($state)),


            Select::make('roles')
                ->label('Role')
                ->relationship('roles', 'name')
                ->preload()
                ->searchable()
                ->required()
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                BadgeColumn::make('role_label')
                    ->label('Role')
                    ->getStateUsing(
                        fn($record) =>
                        $record->hasRole('super_admin') ? 'Superadmin' : 'Smartnakama'
                    )
                    ->colors([
                        'danger' => 'Superadmin',
                        'primary' => 'Smartnakama',
                    ]),
                TextColumn::make('created_at')->dateTime('d M Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('grantSuperadmin')
                    ->label('Grant')
                    ->icon('heroicon-o-key')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn($record) => !$record->hasRole('super_admin'))
                    ->action(fn($record) => $record->assignRole('super_admin'))
                    ->after(
                        fn($record) => Notification::make()
                            ->title('Role granted')
                            ->body("{$record->name} now has Superadmin access.")
                            ->success()
                            ->send()
                    ),

                Tables\Actions\Action::make('revokeSuperadmin')
                    ->label('Revoke')
                    ->icon('heroicon-o-lock-closed')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->hasRole('super_admin'))
                    ->action(fn($record) => $record->removeRole('super_admin'))
                    ->after(
                        fn($record) => Notification::make()
                            ->title('Role revoked')
                            ->body("Superadmin access removed from {$record->name}.")
                            ->warning()
                            ->send()
                    ),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
