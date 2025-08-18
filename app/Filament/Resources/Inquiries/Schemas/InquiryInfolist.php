<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use App\InquiryStatus;
use App\Models\Inquiry;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;

class InquiryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Inquiry Information')
                    ->columnSpanFull()
                    ->headerActions([
                        Action::make('status_badge')
                            ->label(fn (Inquiry $record): string => $record->status->getLabel())
                            ->color(fn (Inquiry $record): string => $record->status->getBadgeColor())
                            ->badge()
                            ->size(Size::Large)
                            ->disabled(),
                    ])
                    ->schema([
                        Grid::make()->schema([
                            TextEntry::make('ticket_id')
                                ->label('Ticket ID')
                                ->weight('bold'),
                            TextEntry::make('first_name'),
                            TextEntry::make('last_name'),
                            TextEntry::make('email')
                                ->label('Email address'),
                            TextEntry::make('created_at')
                                ->dateTime('M d, Y h:i A'),
                            TextEntry::make('updated_at')
                                ->dateTime('M d, Y h:i A'),
                        ]),
                    ]),

                Section::make('Inquiry Details')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('subject'),
                        TextEntry::make('message'),
                    ])
                    ->footerActions([
                        Action::make('reply')
                            ->label('Reply')
                            ->icon(Heroicon::ChatBubbleLeft)
                            ->visible(fn (Inquiry $record): bool => $record->status !== InquiryStatus::Closed)
                            ->color(Color::Blue)
                            ->action(function () {
                                // Reply functionality to be implemented later
                            }),

                        Action::make('mark_as_closed')
                            ->label('Mark as Closed')
                            ->icon(Heroicon::CheckCircle)
                            ->color(Color::Green)
                            ->visible(fn (Inquiry $record): bool => $record->status !== InquiryStatus::Closed)
                            ->requiresConfirmation()
                            ->modalIcon(Heroicon::CheckCircle)
                            ->modalHeading('Mark Inquiry as Closed')
                            ->modalDescription('Are you sure you want to mark this inquiry as closed?')
                            ->modalSubmitActionLabel('Yes, Mark as Closed')
                            ->action(function (Inquiry $record): void {
                                $record->update(['status' => InquiryStatus::Closed]);
                            }),
                    ]),
            ]);
    }
}
