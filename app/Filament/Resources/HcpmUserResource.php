<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HcpmUserResource\Pages;
use App\Models\HcpmUser;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HcpmUserResource extends Resource
{
    protected static ?string $model = HcpmUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'HCPM';
    protected static ?string $label = 'User HCPM';
    protected static ?string $navigationLabel = 'User HCPM';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Biarkan kosong untuk sekarang jika hanya view
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('role')->label('Role')->sortable(),

                Tables\Columns\TextColumn::make('department_id')
                    ->label('Departemen')
                    ->formatStateUsing(fn($state) => $state ?? 'N/A'),

                Tables\Columns\TextColumn::make('Struktural Jabatan')
                    ->label('Jabatan Struktural')
                    ->getStateUsing(
                        fn($record) =>
                        $record->jobTitles->firstWhere('jenis_jabatan', 'Struktural')?->job_titles ?? '—'
                    ),

                Tables\Columns\TextColumn::make('Fungsional Jabatan')
                    ->label('Jabatan Fungsional')
                    ->getStateUsing(
                        fn($record) =>
                        $record->jobTitles->firstWhere('jenis_jabatan', 'Fungsional')?->job_titless ?? '—'
                    ),


                Tables\Columns\TextColumn::make('fungsionalTitle.job_titles')
                    ->label('Jabatan Fungsional')
                    ->formatStateUsing(fn($state) => optional($state->first())->job_titles ?? '—'),
            ])
            ->defaultSort('name')
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            // Tambahkan relation managers jika perlu nanti
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
