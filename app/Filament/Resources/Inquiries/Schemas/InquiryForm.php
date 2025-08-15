<?php
namespace App\Filament\Resources\Inquiries\Schemas;

use App\InquiryStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ticket_id')
                    ->label('Ticket ID')
                    ->disabled()
                    ->dehydrated()
                    ->helperText('This will be generated automatically when creating a new inquiry')
                    ->visible(fn($record) => $record !== null)
                    ->columnSpanFull(),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('subject')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(InquiryStatus::class)
                    ->searchable()
                    ->required(),
            ]);
    }
}
