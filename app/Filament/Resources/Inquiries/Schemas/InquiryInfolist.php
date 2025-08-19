<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use App\Filament\Resources\Inquiries\InquiryResource;
use App\InquiryStatus;
use App\Mail\InquiryReplyMail;
use App\Models\Inquiry;
use App\Models\InquiryReply;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Mail;

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
                            ->form([
                                Textarea::make('message')
                                    ->label('Reply Message')
                                    ->placeholder('Type your reply message here...')
                                    ->required()
                                    ->rows(6)
                                    ->columnSpanFull(),
                            ])
                            ->modalHeading('Reply to Inquiry')
                            ->modalDescription(fn (Inquiry $record): string => "Replying to: {$record->subject} [Ticket: {$record->ticket_id}]")
                            ->modalSubmitActionLabel('Send Reply')
                            ->action(function (array $data, Inquiry $record): void {
                                // Create the reply record
                                $reply = InquiryReply::create([
                                    'inquiry_id' => $record->id,
                                    'user_id' => auth()->id(),
                                    'message' => $data['message'],
                                    'is_sent' => false,
                                ]);

                                // Send the email
                                try {
                                    Mail::send(new InquiryReplyMail($record, $reply));

                                    // Mark as sent
                                    $reply->update([
                                        'is_sent' => true,
                                        'sent_at' => now(),
                                    ]);

                                    // Update inquiry status to In Progress if it's pending
                                    if ($record->status === InquiryStatus::Pending) {
                                        $record->update(['status' => InquiryStatus::InProgress]);
                                    }
                                } catch (\Exception $e) {
                                    // Log the error but don't fail the action
                                    logger()->error('Failed to send inquiry reply email: '.$e->getMessage());
                                }
                            }),

                        Action::make('view_replies')
                            ->label('View Replies')
                            ->icon(Heroicon::ChatBubbleLeftEllipsis)
                            ->color(Color::Gray)
                            ->url(fn (Inquiry $record): string => InquiryResource::getUrl('replies', ['record' => $record]))
                            ->badge(fn (Inquiry $record): int => $record->replies->count())
                            ->badgeColor(Color::Blue),

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
