<?php

namespace App\Filament\Resources;

use App\Models\HcpmUser;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Resources\HcpmUserResource\Pages;

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
        return $form->schema([
            // Kosongkan atau tambahkan kalau perlu form
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                fn() => HcpmUser::query()->with(['department', 'jobTitles']) // Eager load
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->limit(25)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('role')
                    ->label('Role')
                    ->sortable(),

                TextColumn::make('department.name')
                    ->label('Departemen')
                    ->default('N/A'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->color(fn($state) => match ($state) {
                        'Active' => 'success',
                        'On_Leave' => 'warning',
                        'Terminated' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('jobTitlesStruktural')
                    ->label('Jabatan Struktural')
                    ->getStateUsing(
                        fn($record) =>
                        $record->jobTitles->firstWhere('jenis_jabatan', 'Struktural')?->nama_jabatan ?? '—'
                    ),

                TextColumn::make('jobTitlesFungsional')
                    ->label('Jabatan Fungsional')
                    ->getStateUsing(
                        fn($record) =>
                        $record->jobTitles->firstWhere('jenis_jabatan', 'Fungsional')?->nama_jabatan ?? '—'
                    ),
            ])
            ->defaultSort('name')
            ->filters([])
            ->actions([
                // Tambahkan actions jika perlu, seperti View/Edit
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
