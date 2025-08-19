<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use App\Models\Inquiry;
use Filament\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class InquiryRepliesInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Original Message')
                    ->headerActions([
                        Action::make('status_badge')
                            ->label(fn (Inquiry $record): string => $record->status->getLabel())
                            ->color(fn (Inquiry $record): string => $record->status->getBadgeColor())
                            ->badge()
                            ->disabled(),
                    ])
                    ->schema([
                        TextEntry::make('subject')
                            ->label('Subject')
                            ->size('lg')
                            ->weight('bold'),
                        TextEntry::make('customer_info')
                            ->label('From')
                            ->getStateUsing(
                                fn (Inquiry $record): string => "{$record->first_name} {$record->last_name} ({$record->email})"
                            ),
                        TextEntry::make('created_at')
                            ->label('Sent')
                            ->dateTime('M j, Y \a\t g:i A'),
                        TextEntry::make('message')
                            ->label('Message')
                            ->columnSpanFull()
                            ->prose(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),

                Section::make('Replies')

                    ->icon(Heroicon::ChatBubbleLeft)
                    ->schema([
                        RepeatableEntry::make('replies')
                            ->label(fn (Inquiry $record): string => __(':count replies', ['count' => $record->replies()->count()]))
                            ->schema([
                                TextEntry::make('message')->label('Message')->prose(),
                                TextEntry::make('sent_at')->label('Sent at')->date('M j, Y \a\t g:i A'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
