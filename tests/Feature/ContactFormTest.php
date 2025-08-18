<?php

use App\Livewire\ContactForm;
use App\Mail\ContactFormSubmitted;
use App\Models\Inquiry;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

use function Pest\Livewire\livewire;

it('renders successfully', function () {
    livewire(ContactForm::class)
        ->assertStatus(200);
});

it('validates contact form inputs with :dataset', function ($form, $expectedError) {
    livewire(ContactForm::class)
        ->set('first_name', $form['first_name'])
        ->set('last_name', $form['last_name'])
        ->set('email', $form['email'])
        ->set('subject', $form['subject'])
        ->set('message', $form['message'])
        ->call('submitForm')
        ->assertHasErrors([$expectedError]);
})->with([
    'empty first name' => [
        'form' => [
            'first_name' => '',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message that is long enough.',
        ],
        'expectedError' => 'first_name',
    ],
    'short first name' => [
        'form' => [
            'first_name' => 'A',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message that is long enough.',
        ],
        'expectedError' => 'first_name',
    ],
    'long first name' => [
        'form' => [
            'first_name' => str_repeat('A', 51),
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message that is long enough.',
        ],
        'expectedError' => 'first_name',
    ],
    'empty last name' => [
        'form' => [
            'first_name' => 'John',
            'last_name' => '',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message that is long enough.',
        ],
        'expectedError' => 'last_name',
    ],
    'short last name' => [
        'form' => [
            'first_name' => 'John',
            'last_name' => 'D',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message that is long enough.',
        ],
        'expectedError' => 'last_name',
    ],
    'long last name' => [
        'form' => [
            'first_name' => 'John',
            'last_name' => str_repeat('D', 51),
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message that is long enough.',
        ],
        'expectedError' => 'last_name',
    ],
    'empty email' => [
        'form' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => '',
            'subject' => 'Test Subject',
            'message' => 'This is a test message that is long enough.',
        ],
        'expectedError' => 'email',
    ],
    'invalid email format' => [
        'form' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'invalid-email',
            'subject' => 'Test Subject',
            'message' => 'This is a test message that is long enough.',
        ],
        'expectedError' => 'email',
    ],
    'long email' => [
        'form' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => str_repeat('a', 250) . '@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message that is long enough.',
        ],
        'expectedError' => 'email',
    ],
    'empty subject' => [
        'form' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'subject' => '',
            'message' => 'This is a test message that is long enough.',
        ],
        'expectedError' => 'subject',
    ],
    'short subject' => [
        'form' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'subject' => 'Test',
            'message' => 'This is a test message that is long enough.',
        ],
        'expectedError' => 'subject',
    ],
    'long subject' => [
        'form' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'subject' => str_repeat('T', 101),
            'message' => 'This is a test message that is long enough.',
        ],
        'expectedError' => 'subject',
    ],
    'empty message' => [
        'form' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => '',
        ],
        'expectedError' => 'message',
    ],
    'short message' => [
        'form' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'Short',
        ],
        'expectedError' => 'message',
    ],
    'long message' => [
        'form' => [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => str_repeat('M', 1001),
        ],
        'expectedError' => 'message',
    ],
]);

it('successfully submits valid contact form', function () {
    // Create a user to receive notifications
    $user = User::factory()->create();

    expect(Inquiry::count())->toBe(0);

    livewire(ContactForm::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message that is long enough to pass validation.')
        ->call('submitForm')
        ->assertHasNoErrors();

    // Assert inquiry was created
    expect(Inquiry::count())->toBe(1);

    $inquiry = Inquiry::first();
    expect($inquiry->first_name)->toBe('John')
        ->and($inquiry->last_name)->toBe('Doe')
        ->and($inquiry->email)->toBe('john@example.com')
        ->and($inquiry->subject)->toBe('Test Subject')
        ->and($inquiry->message)->toBe('This is a test message that is long enough to pass validation.')
        ->and($inquiry->ticket_id)->not->toBeNull();
});

it('displays success message after successful submission', function () {
    // Create a user to receive notifications
    User::factory()->create();

    livewire(ContactForm::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message that is long enough to pass validation.')
        ->call('submitForm')
        ->assertSet('success', true)
        ->assertSee('Thank you for your message! We\'ll get back to you soon.', escape: false);
});

it('resets form fields after successful submission', function () {
    // Create a user to receive notifications
    User::factory()->create();

    livewire(ContactForm::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message that is long enough to pass validation.')
        ->call('submitForm')
        ->assertSet('first_name', '')
        ->assertSet('last_name', '')
        ->assertSet('email', '')
        ->assertSet('subject', '')
        ->assertSet('message', '');
});

it('sends notification to user when form is submitted', function () {
    // Create a user to receive notifications (this will be the first user)
    $user = User::factory()->create();

    livewire(ContactForm::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message that is long enough to pass validation.')
        ->call('submitForm')
        ->assertNotified();

    $inquiry = Inquiry::first();
    expect($inquiry)->not->toBeNull();
    expect($inquiry->subject)->toBe('Test Subject');
    
    // Verify notification was sent to database for the user
    expect($user->notifications()->count())->toBe(1);
    
    $notification = $user->notifications()->first();
    expect($notification->data['title'])->toBe("New Inquiry {$inquiry->ticket_id} received");
});

it('sends email when contact form is submitted', function () {
    // Create a user to receive notifications
    User::factory()->create();

    // Fake the mail system
    Mail::fake();

    livewire(ContactForm::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message that is long enough to pass validation.')
        ->call('submitForm');

    $inquiry = Inquiry::first();

    // Assert email was queued
    Mail::assertQueued(ContactFormSubmitted::class, function ($mail) use ($inquiry) {
        return $mail->inquiry->id === $inquiry->id;
    });

    // Assert email was sent to the correct address with CC
    Mail::assertQueued(ContactFormSubmitted::class, function ($mail) {
        return $mail->hasTo(config('mail.from.address')) &&
            $mail->hasCc('john@example.com');
    });
});

it('handles case when no user exists for notifications', function () {
    // Don't create any users
    expect(User::count())->toBe(0);

    livewire(ContactForm::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message that is long enough to pass validation.')
        ->call('submitForm')
        ->assertHasNoErrors()
        ->assertSet('success', true);

    // Should still create the inquiry even without users
    expect(Inquiry::count())->toBe(1);
});

it('resets success flag when submitting form again', function () {
    // Create a user to receive notifications
    User::factory()->create();

    $component = livewire(ContactForm::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message that is long enough to pass validation.')
        ->call('submitForm')
        ->assertSet('success', true);

    // Submit again with invalid data
    $component
        ->set('first_name', '')
        ->call('submitForm')
        ->assertSet('success', false)
        ->assertHasErrors(['first_name']);
});
