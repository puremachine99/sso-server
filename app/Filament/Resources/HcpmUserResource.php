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
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $label = 'Smartnakama HCPM';
    protected static ?string $navigationLabel = 'Smartnakama HCPM';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->sortable(),

                Tables\Columns\TextColumn::make('department.name')
                    ->label('Departemen')
                    ->default('N/A'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->color(fn($state) => match ($state) {
                        'Active' => 'success',
                        'On_Leave' => 'warning',
                        'Terminated' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('jobTitlesStruktural')
                    ->label('Jabatan Struktural')
                    ->getStateUsing(
                        fn($record) =>
                        $record->jobTitles->firstWhere('jenis_jabatan', 'Struktural')?->job_title ?? '—'
                    ),

                Tables\Columns\TextColumn::make('jobTitlesFungsional')
                    ->label('Jabatan Fungsional')
                    ->getStateUsing(
                        fn($record) =>
                        $record->jobTitles->firstWhere('jenis_jabatan', 'Fungsional')?->job_title ?? '—'
                    ),
            ])
            ->defaultSort('name')
            ->filters([])
            ->actions([

            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHcpmUsers::route('/'),
            // 'create' => Pages\CreateHcpmUser::route('/create'),
            // 'edit' => Pages\EditHcpmUser::route('/{record}/edit'),
        ];
    }
}
