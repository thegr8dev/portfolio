<?php

namespace App\Services;

class TicketIDGenerator
{
    /**
     * Generate a unique ticket ID in the format AK-MMMDD-NNNN
     * where MMM is the month abbreviation, DD is the day, and NNNN is a unique 4-digit number
     */
    public static function generate(): string
    {
        // Prefix
        $prefix = 'AK';

        // Current month abbreviation (e.g., AUG)
        $month = strtoupper(date('M'));

        // Current day (e.g., 15)
        $day = date('d');

        // Get the latest ticket number for today
        $latestTicket = \App\Models\Inquiry::where('ticket_id', 'like', "{$prefix}-{$month}{$day}-%")
            ->orderBy('id', 'desc')
            ->first();

        // Extract the numeric part or start with 0001
        $nextNumber = 1;
        if ($latestTicket) {
            $parts = explode('-', $latestTicket->ticket_id);
            $lastNumber = (int) end($parts);
            $nextNumber = $lastNumber + 1;
        }

        // Format as 4 digits with leading zeros
        $numberPart = str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);

        // Combine all parts
        return "{$prefix}-{$month}{$day}-{$numberPart}";
    }
}
