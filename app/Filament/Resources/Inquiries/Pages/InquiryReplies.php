<?php

namespace App\Filament\Resources\Inquiries\Pages;

use App\Filament\Resources\Inquiries\InquiryResource;
use App\Filament\Resources\Inquiries\Schemas\InquiryRepliesInfolist;
use App\Models\Inquiry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class InquiryReplies extends ViewRecord
{
    protected static string $resource = InquiryResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        // Load the replies relationship
        /** @var Inquiry $inquiry */
        $inquiry = $this->record;
        $inquiry->load('replies.user');
    }

    public function getTitle(): string
    {
        /** @var Inquiry $record */
        $record = $this->record;

        return 'Conversation - '.$record->ticket_id;
    }

    public function infolist(Schema $schema): Schema
    {
        return InquiryRepliesInfolist::configure($schema);
    }

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
