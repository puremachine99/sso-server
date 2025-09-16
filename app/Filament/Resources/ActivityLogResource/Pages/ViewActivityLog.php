<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewActivityLog extends ViewRecord
{
    protected static string $resource = ActivityLogResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Summary')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')->label('Time')->dateTime('Y-m-d H:i:s'),
                        Infolists\Components\TextEntry::make('event')->badge(),
                        Infolists\Components\TextEntry::make('description')->columnSpanFull(),
                    ])->columns(3),

                Infolists\Components\Section::make('Causer & Subject')
                    ->schema([
                        Infolists\Components\TextEntry::make('causer.name')->label('Causer'),
                        Infolists\Components\TextEntry::make('subject_type')->label('Subject Type'),
                        Infolists\Components\TextEntry::make('subject_id')->label('Subject ID'),
                    ])->columns(3),

                Infolists\Components\Section::make('Request')
                    ->schema([
                        Infolists\Components\TextEntry::make('method')->badge(),
                        Infolists\Components\TextEntry::make('ip')->label('IP'),
                        Infolists\Components\TextEntry::make('url')->label('URL')->columnSpanFull(),
                        Infolists\Components\TextEntry::make('user_agent')->label('User Agent')->columnSpanFull(),
                    ])->columns(3),

                Infolists\Components\Section::make('Properties')
                    ->schema([
                        Infolists\Components\KeyValueEntry::make('properties')
                            ->label('Details')
                            ->json()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

