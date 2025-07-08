<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\ClientApp;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\ClientAppResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClientAppResource\RelationManagers;

class ClientAppResource extends Resource
{
    protected static ?string $model = \Laravel\Passport\Client::class;
    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    protected static ?string $navigationGroup = 'Management Apps';
    protected static ?string $navigationLabel = 'Client Apps';
    protected static ?int $navigationSort = -1;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required()->maxLength(255),

            TextInput::make('redirect_uris')
                ->label('Redirect URI')
                ->required()
                ->url()
                ->maxLength(2048)
                ->formatStateUsing(fn($state) => is_array($state) ? $state[0] ?? '' : $state)
                ->dehydrateStateUsing(fn($state) => [$state]),

            CheckboxList::make('grant_types')
                ->label('Grant Types')
                ->options([
                    'authorization_code' => 'Authorization Code',
                    'refresh_token' => 'Refresh Token',
                    'client_credentials' => 'Client Credentials',
                    'password' => 'Password',
                    'personal_access' => 'Personal Access',
                ])
                ->columns(2)
                ->default(['authorization_code', 'refresh_token'])
                ->required(),

            Toggle::make('revoked')->label('Revoked')->disabled(),

            TextInput::make('secret')->disabled()->dehydrated(false)->label('Client Secret'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Client ID')
                    ->copyable(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),

                Tables\Columns\TextColumn::make('secret')
                    ->label('Client Secret')
                    ->copyable()
                    ->limit(10),


                Tables\Columns\TextColumn::make('redirect_uris')->limit(40)->label('Redirect URI'),
                Tables\Columns\IconColumn::make('revoked')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('showEnv')
                    ->label('ENV')
                    ->icon('heroicon-o-document-text')
                    ->modalHeading('Salin Konfigurasi .env Client')
                    ->modalSubmitAction(false) // tidak ada tombol submit
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(fn($record) => view('components.env-preview', [
                        'client' => $record,
                    ]))
                    ->color('gray'),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListClientApps::route('/'),
            'create' => Pages\CreateClientApp::route('/create'),
            'edit' => Pages\EditClientApp::route('/{record}/edit'),
        ];
    }
}
