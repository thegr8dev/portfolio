<?php

use App\Mail\InquiryReplyMail;
use App\Models\Inquiry;
use App\Models\InquiryReply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('inquiry reply mail has correct envelope', function () {
    $inquiry = Inquiry::factory()->create([
        'email' => 'customer@example.com',
        'subject' => 'Test Inquiry Subject',
    ]);

    $user = User::factory()->create();

    $reply = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
        'message' => 'This is a test reply',
    ]);

    $mail = new InquiryReplyMail($inquiry, $reply);
    $envelope = $mail->envelope();

    expect($envelope->to[0]->address)->toBe('customer@example.com');
    expect($envelope->subject)->toBe("Re: Test Inquiry Subject [Ticket: {$inquiry->ticket_id}]");
});

test('inquiry reply mail has correct content', function () {
    $inquiry = Inquiry::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'subject' => 'Test Subject',
    ]);

    $user = User::factory()->create();

    $reply = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
        'message' => 'Thank you for your inquiry. Here is our response.',
    ]);

    $mail = new InquiryReplyMail($inquiry, $reply);
    $content = $mail->content();

    expect($content->markdown)->toBe('emails.inquiry-reply');
    expect($content->with['inquiry'])->toBeInstanceOf(Inquiry::class);
    expect($content->with['reply'])->toBeInstanceOf(InquiryReply::class);
    expect($content->with['inquiry']->id)->toBe($inquiry->id);
    expect($content->with['reply']->id)->toBe($reply->id);
});

test('inquiry reply mail is queued', function () {
    $inquiry = Inquiry::factory()->create();
    $user = User::factory()->create();
    $reply = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
    ]);

    $mail = new InquiryReplyMail($inquiry, $reply);

    expect($mail)->toBeInstanceOf(\Illuminate\Contracts\Queue\ShouldQueue::class);
});

test('inquiry reply mail can be sent successfully', function () {
    Mail::fake();

    $inquiry = Inquiry::factory()->create([
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'subject' => 'Product Question',
        'email' => 'jane@example.com',
    ]);

    $user = User::factory()->create(['name' => 'Support Agent']);

    $reply = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
        'message' => 'We appreciate your inquiry about our product.',
    ]);

    $mail = new InquiryReplyMail($inquiry, $reply);

    // Queue the mail
    Mail::to($inquiry->email)->queue($mail);

    // Assert mail was queued
    Mail::assertQueued(InquiryReplyMail::class, function ($mail) use ($inquiry, $reply) {
        return $mail->inquiry->id === $inquiry->id &&
               $mail->reply->id === $reply->id;
    });
});

test('inquiry reply mail handles long messages', function () {
    Mail::fake();

    $longMessage = str_repeat('This is a very long reply message. ', 100);

    $inquiry = Inquiry::factory()->create([
        'subject' => 'Long Response Test',
        'email' => 'customer@example.com',
    ]);

    $user = User::factory()->create();

    $reply = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
        'message' => $longMessage,
    ]);

    $mail = new InquiryReplyMail($inquiry, $reply);

    // Queue the mail
    Mail::to($inquiry->email)->queue($mail);

    // Assert mail was queued with long message
    Mail::assertQueued(InquiryReplyMail::class, function ($mail) use ($longMessage) {
        return $mail->reply->message === $longMessage;
    });
});

test('inquiry reply mail handles special characters', function () {
    Mail::fake();

    $inquiry = Inquiry::factory()->create([
        'first_name' => 'José',
        'last_name' => 'García',
        'subject' => 'Prüfung & Test émails',
        'email' => 'jose@example.com',
    ]);

    $user = User::factory()->create();

    $specialMessage = 'Hola José! Gracias por tu consulta. Estamos aquí para ayudarte.';

    $reply = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
        'message' => $specialMessage,
    ]);

    $mail = new InquiryReplyMail($inquiry, $reply);

    // Queue the mail
    Mail::to($inquiry->email)->queue($mail);

    // Assert mail was queued with special characters
    Mail::assertQueued(InquiryReplyMail::class, function ($mail) use ($specialMessage) {
        return $mail->inquiry->first_name === 'José' &&
               $mail->inquiry->last_name === 'García' &&
               $mail->inquiry->subject === 'Prüfung & Test émails' &&
               $mail->reply->message === $specialMessage;
    });
});
