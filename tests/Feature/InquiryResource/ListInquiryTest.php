<?php

use App\Filament\Resources\Inquiries\Pages\ListInquiries;
use App\InquiryStatus;
use App\Models\Inquiry;
use Filament\Actions\CreateAction;
use Filament\Actions\Testing\TestAction;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

it('can load the list page', function () {
    livewire(ListInquiries::class)
        ->assertOk();
});

it('can display inquiries in the table', function () {
    $inquiries = Inquiry::factory()->count(5)->create();

    livewire(ListInquiries::class)
        ->assertOk()
        ->assertCanSeeTableRecords($inquiries);
});

it('can search inquiries by ticket ID', function () {
    $inquiries = Inquiry::factory()->count(5)->create();
    $targetInquiry = $inquiries->first();

    livewire(ListInquiries::class)
        ->assertCanSeeTableRecords($inquiries)
        ->searchTable($targetInquiry->ticket_id)
        ->assertCanSeeTableRecords([$targetInquiry])
        ->assertCanNotSeeTableRecords($inquiries->skip(1));
});

it('can search inquiries by name', function () {
    $inquiries = Inquiry::factory()->count(5)->create();
    $targetInquiry = $inquiries->first();

    livewire(ListInquiries::class)
        ->assertCanSeeTableRecords($inquiries)
        ->searchTable($targetInquiry->first_name)
        ->assertCanSeeTableRecords([$targetInquiry])
        ->assertCanNotSeeTableRecords($inquiries->skip(1));
});

it('can search inquiries by email', function () {
    $inquiries = Inquiry::factory()->count(5)->create();
    $targetInquiry = $inquiries->first();

    livewire(ListInquiries::class)
        ->assertCanSeeTableRecords($inquiries)
        ->searchTable($targetInquiry->email)
        ->assertCanSeeTableRecords([$targetInquiry])
        ->assertCanNotSeeTableRecords($inquiries->skip(1));
});

it('can search inquiries by subject', function () {
    $inquiries = Inquiry::factory()->count(5)->create();
    $targetInquiry = $inquiries->first();

    livewire(ListInquiries::class)
        ->assertCanSeeTableRecords($inquiries)
        ->searchTable($targetInquiry->subject)
        ->assertCanSeeTableRecords([$targetInquiry])
        ->assertCanNotSeeTableRecords($inquiries->skip(1));
});

it('can sort inquiries by ticket_id', function () {
    $inquiries = Inquiry::factory()->count(5)->create();

    livewire(ListInquiries::class)
        ->assertCanSeeTableRecords($inquiries)
        ->sortTable('ticket_id')
        ->assertCanSeeTableRecords($inquiries->sortBy('ticket_id'), inOrder: true)
        ->sortTable('ticket_id', 'desc')
        ->assertCanSeeTableRecords($inquiries->sortByDesc('ticket_id'), inOrder: true);
});

it('can sort inquiries by created_at', function () {
    $inquiries = Inquiry::factory()->count(5)->create();

    livewire(ListInquiries::class)
        ->assertCanSeeTableRecords($inquiries)
        ->sortTable('created_at')
        ->assertCanSeeTableRecords($inquiries->sortBy('created_at'), inOrder: true)
        ->sortTable('created_at', 'desc')
        ->assertCanSeeTableRecords($inquiries->sortByDesc('created_at'), inOrder: true);
});

it('can filter inquiries by status', function () {
    $pendingInquiries = Inquiry::factory()->count(3)->create(['status' => InquiryStatus::Pending]);
    $resolvedInquiries = Inquiry::factory()->count(2)->create(['status' => InquiryStatus::Resolved]);

    livewire(ListInquiries::class)
        ->assertCanSeeTableRecords($pendingInquiries->merge($resolvedInquiries))
        ->filterTable('status', InquiryStatus::Pending->value)
        ->assertCanSeeTableRecords($pendingInquiries)
        ->assertCanNotSeeTableRecords($resolvedInquiries);
});

it('can access create action from header', function () {
    livewire(ListInquiries::class)
        ->assertActionExists(CreateAction::class);
});

it('can bulk delete inquiries', function () {
    $inquiries = Inquiry::factory()->count(3)->create();

    livewire(ListInquiries::class)
        ->assertCanSeeTableRecords($inquiries)
        ->selectTableRecords($inquiries)
        ->callAction(TestAction::make('delete')->table($inquiries)->bulk())
        ->assertNotified()
        ->assertCanNotSeeTableRecords($inquiries);

    foreach ($inquiries as $inquiry) {
        assertDatabaseMissing(Inquiry::class, ['id' => $inquiry->id]);
    }
});

it('can access view action from table row', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(ListInquiries::class)
        ->assertActionExists(TestAction::make('view')->table($inquiry));
});

it('can access edit action from table row', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(ListInquiries::class)
        ->assertActionExists(TestAction::make('edit')->table($inquiry));
});

it('can access delete action from table row', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(ListInquiries::class)
        ->assertActionExists(TestAction::make('delete')->table($inquiry));
});

it('can delete inquiry from table row action', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(ListInquiries::class)
        ->callAction(TestAction::make('delete')->table($inquiry))
        ->assertNotified()
        ->assertCanNotSeeTableRecords([$inquiry]);

    assertDatabaseMissing(Inquiry::class, [
        'id' => $inquiry->id,
    ]);
});
