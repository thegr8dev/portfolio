<?php

namespace App\Observers;

use App\InquiryStatus;
use App\Mail\ContactFormSubmitted;
use App\Models\Inquiry;
use App\Services\TicketIDGenerator;
use Illuminate\Support\Facades\Mail;

class InquiryObserver
{
    /**
     * Handle the Inquiry "creating" event.
     *
     * This will run before the model is created and saved to the database
     */
    public function creating(Inquiry $inquiry): void
    {
        // Generate the ticket ID if it's not already set
        if (empty($inquiry->ticket_id)) {
            $inquiry->ticket_id = TicketIDGenerator::generate();
        }

        if (empty($inquiry->status)) {
            $inquiry->status = InquiryStatus::Pending;
        }
    }

    /**
     * Handle the Inquiry "created" event.
     *
     * This will run after the model is created and saved to the database
     */
    public function created(Inquiry $inquiry): void
    {
        Mail::to(config('mail.from.address'))
            ->cc($inquiry->email)
            ->later(now()->addMinutes(1), new ContactFormSubmitted($inquiry));
    }
}
