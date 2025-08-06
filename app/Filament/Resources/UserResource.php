<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\HcpmUser;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;

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
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->disabledOn('edit'),

            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->disabledOn('edit'),

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
                    ->getStateUsing(fn($record) => $record->roles->pluck('name')->implode(', ')),

                BadgeColumn::make('hcpm_status')
                    ->label('Status HCPM')
                    ->getStateUsing(function ($record) {
                        return $record->hcpm()?->status ?? 'Unknown';
                    })
                    ->colors([
                        'success' => 'Active',
                        'warning' => 'On_Leave',
                        'danger' => 'Terminated',
                        'gray' => 'Unknown',
                    ])
                    ->sortable(),

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
                // TextColumn::make('job_titles_struktural')
                //     ->label('Jabatan Struktural')
                //     ->sortable()
                //     ->toggleable(),

                // TextColumn::make('job_titles_fungsional')
                //     ->label('Jabatan Fungsional')
                //     ->sortable()
                //     ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y, H:i'),
            ])
            ->filters([
                SelectFilter::make('hcpm_status')
                    ->label('HCPM Status')
                    ->options([
                        'Active' => 'Active',
                        'On_Leave' => 'On Leave',
                        'Terminated' => 'Terminated',
                        'Unknown' => 'Unknown',
                    ]),


                SelectFilter::make('source')
                    ->label('Account Type')
                    ->options([
                        'manual' => 'Manual',
                        'synced user' => 'Synced User',
                    ]),

                SelectFilter::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name'),
            ])
            ->actions([
                Action::make('reset_password')
                    ->label('Reset Password')
                    ->icon('heroicon-o-key')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reset Password')
                    ->modalDescription('Reset password user ini ke 12345678 di kedua sistem (Portal & HCPM)?')
                    ->modalSubmitActionLabel('Reset')
                    ->action(function ($record) {
                        $newPassword = '12345678';
                        $hashed = Hash::make($newPassword);

                        // Update di portal
                        $record->update([
                            'password' => $hashed,
                        ]);

                        // Update di HCPM jika ditemukan by email
                        $hcpmUser = HcpmUser::where('email', $record->email)->first();
                        if ($hcpmUser) {
                            $hcpmUser->update([
                                'password' => $hashed,
                            ]);
                        }

                        Notification::make()
                            ->title('Password berhasil direset')
                            ->success()
                            ->send();
                    }),
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
