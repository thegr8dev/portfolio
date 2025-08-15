<?php

use App\Models\Inquiry;

it('generates a ticket ID in the correct format when creating an inquiry', function () {
    // Create a new inquiry
    $inquiry = Inquiry::factory()->create([
        'ticket_id' => null, // Force the observer to generate the ticket ID
    ]);

    // Regex pattern to match the expected format: AK-MMM##-####
    $pattern = '/^AK-[A-Z]{3}\d{2}-\d{4}$/';

    // Assert the ticket ID matches the expected pattern
    expect($inquiry->ticket_id)->toMatch($pattern);

    // Get the current month and day
    $currentMonth = strtoupper(date('M'));
    $currentDay   = date('d');

    // Assert the ticket ID contains the correct month and day
    expect($inquiry->ticket_id)->toContain("{$currentMonth}{$currentDay}");
});

it('generates a unique ticket ID for each inquiry', function () {
    // Create multiple inquiries
    $inquiries = Inquiry::factory()->count(5)->create([
        'ticket_id' => null, // Force the observer to generate the ticket IDs
    ]);

    // Get all the ticket IDs
    $ticketIds = $inquiries->pluck('ticket_id')->toArray();

    // Assert all ticket IDs are unique
    expect(count($ticketIds))->toBe(count(array_unique($ticketIds)));
});

it('generates sequential numbers for ticket IDs created on the same day', function () {
    // Create two inquiries
    $inquiry1 = Inquiry::factory()->create([
        'ticket_id' => null,
    ]);

    $inquiry2 = Inquiry::factory()->create([
        'ticket_id' => null,
    ]);

    // Extract the numeric parts
    $parts1 = explode('-', $inquiry1->ticket_id);
    $parts2 = explode('-', $inquiry2->ticket_id);

    $number1 = (int) end($parts1);
    $number2 = (int) end($parts2);

    // Assert the second number is one more than the first
    expect($number2)->toBe($number1 + 1);
});
