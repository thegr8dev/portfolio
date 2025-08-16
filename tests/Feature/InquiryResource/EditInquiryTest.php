<?php

use App\Filament\Resources\Inquiries\Pages\EditInquiry;
use App\InquiryStatus;
use App\Models\Inquiry;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;


it('can load the edit page', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(EditInquiry::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->assertOk();
});

it('displays current inquiry data in form', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(EditInquiry::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->assertOk()
        ->assertSchemaStateSet([
            'ticket_id' => $inquiry->ticket_id,
            'first_name' => $inquiry->first_name,
            'last_name' => $inquiry->last_name,
            'email' => $inquiry->email,
            'subject' => $inquiry->subject,
            'message' => $inquiry->message,
            'status' => $inquiry->status,
        ]);
});

it('can update an inquiry', function () {
    $inquiry = Inquiry::factory()->create(['status' => InquiryStatus::Pending]);
    $newData = Inquiry::factory()->make(['status' => InquiryStatus::InProgress]);

    livewire(EditInquiry::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->fillForm([
            'first_name' => $newData->first_name,
            'last_name' => $newData->last_name,
            'email' => $newData->email,
            'subject' => $newData->subject,
            'message' => $newData->message,
            'status' => $newData->status->value,
        ])
        ->call('save')
        ->assertNotified();

    assertDatabaseHas(Inquiry::class, [
        'id' => $inquiry->id,
        'ticket_id' => $inquiry->ticket_id, // Should not change
        'first_name' => $newData->first_name,
        'last_name' => $newData->last_name,
        'email' => $newData->email,
        'subject' => $newData->subject,
        'message' => $newData->message,
        'status' => $newData->status->value,
    ]);
});

it('validates form data when updating inquiry with :dataset', function ($data, $expectedErrors) {
    $inquiry = Inquiry::factory()->create();
    $newData = Inquiry::factory()->make();

    livewire(EditInquiry::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->fillForm([
            'first_name' => $newData->first_name,
            'last_name' => $newData->last_name,
            'email' => $newData->email,
            'subject' => $newData->subject,
            'message' => $newData->message,
            'status' => $newData->status->value,
            ...$data,
        ])
        ->call('save')
        ->assertHasFormErrors($expectedErrors)
        ->assertNotNotified();
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

it('can access view action from edit page', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(EditInquiry::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->assertActionExists(ViewAction::class);
});

it('can access delete action from edit page', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(EditInquiry::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->assertActionExists(DeleteAction::class);
});

it('can delete inquiry from edit page', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(EditInquiry::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->callAction(DeleteAction::class)
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseMissing(Inquiry::class, [
        'id' => $inquiry->id,
    ]);
});

it('preserves ticket_id when updating', function () {
    $inquiry = Inquiry::factory()->create();
    $originalTicketId = $inquiry->ticket_id;

    livewire(EditInquiry::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->fillForm([
            'first_name' => 'Updated Name',
        ])
        ->call('save')
        ->assertNotified();

    // Ticket ID should remain unchanged
    assertDatabaseHas(Inquiry::class, [
        'id' => $inquiry->id,
        'ticket_id' => $originalTicketId,
        'first_name' => 'Updated Name',
    ]);
});
