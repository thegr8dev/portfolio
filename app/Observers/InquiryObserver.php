<?php

namespace App\Observers;

use App\Models\Inquiry;
use App\Services\TicketIDGenerator;

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
    }
}
