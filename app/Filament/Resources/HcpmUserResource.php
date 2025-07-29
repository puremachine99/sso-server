<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HcpmUserResource\Pages;
use App\Filament\Resources\HcpmUserResource\RelationManagers;
use App\Models\HcpmUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HcpmUserResource extends Resource
{
    protected static ?string $model = HcpmUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Columns\TextColumn::make('name')->label('Nama'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('userJobTitles.job_title')
                    ->label('Jabatan')
                    ->limit(2)
                    ->formatStateUsing(fn($state) => collect($state)->pluck('job_title')->implode(', ')),
                Tables\Columns\TextColumn::make('smartnakamaProfile.photo')
                    ->label('Photo Link')
                    ->url(fn($record) => $record->smartnakamaProfile?->photo, true)
                    ->openUrlInNewTab(),
                // Tambahkan kolom lain dari relasi sesuai kebutuhan
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListHcpmUsers::route('/'),
            'create' => Pages\CreateHcpmUser::route('/create'),
            'edit' => Pages\EditHcpmUser::route('/{record}/edit'),
        ];
    }
}
