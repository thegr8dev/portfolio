<?php

use App\Filament\Resources\Inquiries\Pages\InquiryReplies;
use App\Models\Inquiry;
use App\Models\InquiryReply;
use App\Models\User;

use function Pest\Livewire\livewire;

test('can load inquiry replies page', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(InquiryReplies::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->assertOk();
});

test('displays inquiry data correctly on replies page', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(InquiryReplies::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->assertOk()
        ->assertSee($inquiry->subject)
        ->assertSee($inquiry->ticket_id)
        ->assertSee($inquiry->first_name)
        ->assertSee($inquiry->last_name);
});

test('displays empty state when no replies exist', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(InquiryReplies::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->assertOk()
        ->assertSee('0 replies'); // RepeatableEntry shows count in label
});

test('displays replies with messages and dates', function () {
    $inquiry = Inquiry::factory()->create();
    $user = User::factory()->create(['name' => 'Support Agent']);

    InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
        'message' => 'First reply message',
        'is_sent' => true,
        'sent_at' => now()->subHours(2),
    ]);

    InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
        'message' => 'Second reply message',
        'is_sent' => false,
        'sent_at' => null,
    ]);

    livewire(InquiryReplies::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->assertOk()
        ->assertSee('2 replies')  // RepeatableEntry label shows count
        ->assertSee('First reply message')  // Message content
        ->assertSee('Second reply message')  // Message content
        ->assertSee('Message')  // TextEntry labels
        ->assertSee('Sent at');  // TextEntry labels
});

test('shows correct inquiry status badge', function () {
    $inquiry = Inquiry::factory()->create(['status' => 'In Progress']);

    livewire(InquiryReplies::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->assertOk()
        ->assertSee('In Progress');
});
