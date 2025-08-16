<?php

use App\Filament\Resources\Inquiries\Pages\CreateInquiry;
use App\InquiryStatus;
use App\Models\Inquiry;
use App\Models\User;
use Filament\Facades\Filament;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;



it('can load the create page', function () {
    livewire(CreateInquiry::class)
        ->assertOk();
});

it('can create a new inquiry', function () {
    $inquiryData = Inquiry::factory()->make();

    livewire(CreateInquiry::class)
        ->fillForm([
            'first_name' => $inquiryData->first_name,
            'last_name' => $inquiryData->last_name,
            'email' => $inquiryData->email,
            'subject' => $inquiryData->subject,
            'message' => $inquiryData->message,
            'status' => InquiryStatus::Pending->value,
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Inquiry::class, [
        'first_name' => $inquiryData->first_name,
        'last_name' => $inquiryData->last_name,
        'email' => $inquiryData->email,
        'subject' => $inquiryData->subject,
        'message' => $inquiryData->message,
        'status' => InquiryStatus::Pending->value,
    ]);

    // Check that ticket_id was generated
    $createdInquiry = Inquiry::where('email', $inquiryData->email)->first();
    expect($createdInquiry->ticket_id)->not->toBeNull();
});

it('validates form data when creating inquiry with :dataset', function ($data, $expectedErrors) {
    $inquiryData = Inquiry::factory()->make();

    livewire(CreateInquiry::class)
        ->fillForm([
            'first_name' => $inquiryData->first_name,
            'last_name' => $inquiryData->last_name,
            'email' => $inquiryData->email,
            'subject' => $inquiryData->subject,
            'message' => $inquiryData->message,
            'status' => InquiryStatus::Pending->value,
            ...$data,
        ])
        ->call('create')
        ->assertHasFormErrors($expectedErrors)
        ->assertNotNotified()
        ->assertNoRedirect();
})->with([
    'empty first name' => [
        ['first_name' => ''],
        ['first_name' => 'required']
    ],
    'empty last name' => [
        ['last_name' => ''],
        ['last_name' => 'required']
    ],
    'empty email' => [
        ['email' => ''],
        ['email' => 'required']
    ],
    'invalid email format' => [
        ['email' => 'invalid-email'],
        ['email' => 'email']
    ],
    'empty subject' => [
        ['subject' => ''],
        ['subject' => 'required']
    ],
    'empty message' => [
        ['message' => ''],
        ['message' => 'required']
    ],
    'empty status' => [
        ['status' => ''],
        ['status' => 'required']
    ],
]);
