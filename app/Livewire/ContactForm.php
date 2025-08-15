<?php
namespace App\Livewire;

use App\InquiryStatus;
use App\Models\Inquiry;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ContactForm extends Component
{
    #[Rule('required|min:2|max:50')]
    public $first_name = '';

    #[Rule('required|min:2|max:50')]
    public $last_name = '';

    #[Rule('required|email|max:255')]
    public $email = '';

    #[Rule('required|min:5|max:100')]
    public $subject = '';

    #[Rule('required|min:10|max:1000')]
    public $message = '';

    public $success = false;

    public function submitForm()
    {
        $validated = $this->validate();

        Inquiry::create([
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'subject'    => $this->subject,
            'message'    => $this->message,
            'status'     => InquiryStatus::Pending,
        ]);

        $this->reset(['first_name', 'last_name', 'email', 'subject', 'message']);
        $this->success = true;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
