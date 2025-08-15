<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use App\Models\Inquiry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InquiryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Inquiry Information')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()->schema([
                            TextEntry::make('ticket_id')
                                ->label('Ticket ID')
                                ->weight('bold'),
                            TextEntry::make('first_name'),
                            TextEntry::make('last_name'),
                            TextEntry::make('subject'),
                            TextEntry::make('email')
                                ->label('Email address'),
                            TextEntry::make('status')
                                ->badge()
                                ->color(fn (Inquiry $record) => $record->status->getBadgeColor()),
                            TextEntry::make('created_at')
                                ->dateTime('M d, Y h:i A'),
                            TextEntry::make('updated_at')
                                ->dateTime('M d, Y h:i A'),
                        ]),
                    ]),
            ]);
    }
}
