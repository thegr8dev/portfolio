<?php

namespace App\Livewire;

use App\Filament\Resources\Inquiries\InquiryResource;
use App\Models\Inquiry;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ContactForm extends Component
{
    #[Rule('required|min:2|max:50')]
    public string $first_name = '';

    #[Rule('required|min:2|max:50')]
    public string $last_name = '';

    #[Rule('required|email|max:255')]
    public string $email = '';

    #[Rule('required|min:5|max:100')]
    public string $subject = '';

    #[Rule('required|min:10|max:1000')]
    public string $message = '';

    public bool $success = false;

    public function submitForm(): void
    {
        $this->success = false;

        /** @var array<string, mixed> $validated */
        $validated = $this->validate();

        $inquiry = Inquiry::create($validated);

        $this->reset(['first_name', 'last_name', 'email', 'subject', 'message']);

        $receiver = User::first();

        if ($receiver) {
            Notification::make()
                ->title("New Inquiry {$inquiry->ticket_id} received")
                ->body("A new inquiry has been submitted with the subject: {$inquiry->subject}")
                ->actions([
                    Action::make('view')
                        ->button()
                        ->markAsRead()
                        ->url(InquiryResource::getUrl('view', ['record' => $inquiry]), shouldOpenInNewTab: true),
                ])
                ->sendToDatabase([$receiver]);
        }

        $this->success = true;
    }

    public function render(): View
    {
        return view('livewire.contact-form');
    }
}
