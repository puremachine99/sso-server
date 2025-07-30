<?php

namespace App\Filament\Resources;

use App\Models\HcpmUser;
use App\Models\Department;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\Filter;
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
            // Bisa diisi jika nanti mendukung edit atau create
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn() => HcpmUser::query()->with(['department', 'jobTitles']))
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
                    ->default('N/A')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->color(fn($state) => match ($state) {
                        'Active' => 'success',
                        'On_Leave' => 'warning',
                        'Terminated' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('job_titles_struktural')
                    ->label('Jabatan Struktural')
                    ->sortable(),

                TextColumn::make('job_titles_fungsional')
                    ->label('Jabatan Fungsional')
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Karyawan')
                    ->options([
                        'Active' => 'Active',
                        'On_Leave' => 'On Leave',
                        'Terminated' => 'Terminated',
                    ])
                    ->query(function ($query, $value) {
                        return $query->whereHas('terminationDetails', function ($sub) use ($value) {
                            if ($value === 'Active') {
                                $sub->whereNull('id'); // Tidak ada termination
                            } else {
                                $sub->where('status', strtolower($value));
                            }
                        });
                    }),

                SelectFilter::make('role')
                    ->label('Role')
                    ->options(fn() => HcpmUser::query()->distinct()->pluck('role', 'role')->filter()),

                SelectFilter::make('department_id')
                    ->label('Departemen')
                    ->relationship('department', 'name')
                    ->searchable(),
            ])
            ->actions([
                ViewAction::make(), // Hanya view detail
            ])
            ->bulkActions([
                // Contoh: Export CSV (kalau mau diaktifkan)
                // Tables\Actions\BulkAction::make('export')->action(fn (Collection $records) => ...)
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
            // 'create' => Pages\CreateHcpmUser::route('/create'), // Nonaktif
            // 'edit' => Pages\EditHcpmUser::route('/{record}/edit'), // Nonaktif
        ];
    }
}
