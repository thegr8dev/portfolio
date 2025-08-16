<?php

use App\Filament\Resources\Inquiries\Pages\ViewInquiry;
use App\Models\Inquiry;
use App\Models\User;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('can load the view page', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(ViewInquiry::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->assertOk();
});

it('displays inquiry data correctly on view page', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(ViewInquiry::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->assertOk()
        ->assertSee($inquiry->ticket_id)
        ->assertSee($inquiry->first_name)
        ->assertSee($inquiry->last_name)
        ->assertSee($inquiry->email)
        ->assertSee($inquiry->subject);
});

it('can access edit action from view page', function () {
    $inquiry = Inquiry::factory()->create();

    livewire(ViewInquiry::class, [
        'record' => $inquiry->ticket_id,
    ])
        ->assertActionExists(EditAction::class);
});
