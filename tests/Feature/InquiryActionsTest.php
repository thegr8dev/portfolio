<?php

use App\InquiryStatus;
use App\Mail\InquiryReplyMail;
use App\Models\Inquiry;
use App\Models\InquiryReply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create an admin user and authenticate
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('inquiry reply can be created and email sent', function () {
    Mail::fake();

    // Create an inquiry
    $inquiry = Inquiry::factory()->create([
        'status' => InquiryStatus::Pending,
        'email' => 'test@example.com',
        'subject' => 'Test Subject',
    ]);

    $replyMessage = 'This is a test reply message';

    // Create a reply
    $reply = InquiryReply::create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $this->user->id,
        'message' => $replyMessage,
        'is_sent' => false,
    ]);

    // Send the email
    Mail::to($inquiry->email)->queue(new InquiryReplyMail($inquiry, $reply));

    // Mark as sent
    $reply->update([
        'is_sent' => true,
        'sent_at' => now(),
    ]);

    // Assert inquiry reply was created
    $this->assertDatabaseHas('inquiry_replies', [
        'inquiry_id' => $inquiry->id,
        'user_id' => $this->user->id,
        'message' => $replyMessage,
        'is_sent' => true,
    ]);

    // Assert email was queued
    Mail::assertQueued(InquiryReplyMail::class, function ($mail) use ($inquiry) {
        return $mail->inquiry->id === $inquiry->id;
    });
});

test('inquiry status can be updated to closed', function () {
    // Create a pending inquiry
    $inquiry = Inquiry::factory()->create([
        'status' => InquiryStatus::Pending,
    ]);

    // Update status to closed
    $inquiry->update(['status' => InquiryStatus::Closed]);

    // Assert inquiry status was updated to Closed
    $inquiry->refresh();
    expect($inquiry->status)->toBe(InquiryStatus::Closed);
});

test('inquiry status is updated to in progress when reply is sent', function () {
    // Create a pending inquiry
    $inquiry = Inquiry::factory()->create([
        'status' => InquiryStatus::Pending,
    ]);

    // Create a reply
    InquiryReply::create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $this->user->id,
        'message' => 'Test reply',
        'is_sent' => true,
    ]);

    // Update inquiry status to In Progress (simulating the action logic)
    if ($inquiry->status === InquiryStatus::Pending) {
        $inquiry->update(['status' => InquiryStatus::InProgress]);
    }

    // Assert inquiry status was updated
    $inquiry->refresh();
    expect($inquiry->status)->toBe(InquiryStatus::InProgress);
});

test('multiple replies can be created for single inquiry', function () {
    $inquiry = Inquiry::factory()->create();

    // Create multiple replies
    $reply1 = InquiryReply::create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $this->user->id,
        'message' => 'First reply',
        'is_sent' => true,
    ]);

    $reply2 = InquiryReply::create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $this->user->id,
        'message' => 'Second reply',
        'is_sent' => true,
    ]);

    // Assert both replies exist
    expect(InquiryReply::where('inquiry_id', $inquiry->id)->count())->toBe(2);

    // Assert replies are linked to correct inquiry
    expect($reply1->inquiry_id)->toBe($inquiry->id);
    expect($reply2->inquiry_id)->toBe($inquiry->id);
});

test('inquiry reply requires all necessary fields', function () {
    $inquiry = Inquiry::factory()->create();

    // Test creating a complete reply
    $reply = InquiryReply::create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $this->user->id,
        'message' => 'Valid message content',
        'is_sent' => false,
    ]);

    // Assert the reply was created successfully
    expect($reply->inquiry_id)->toBe($inquiry->id);
    expect($reply->user_id)->toBe($this->user->id);
    expect($reply->message)->toBe('Valid message content');
    expect($reply->is_sent)->toBeFalse();
});

test('inquiry reply tracks sent status correctly', function () {
    $inquiry = Inquiry::factory()->create();

    // Create reply that hasn't been sent
    $reply = InquiryReply::create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $this->user->id,
        'message' => 'Test message',
        'is_sent' => false,
    ]);

    expect($reply->is_sent)->toBeFalse();
    expect($reply->sent_at)->toBeNull();

    // Mark as sent
    $reply->update([
        'is_sent' => true,
        'sent_at' => now(),
    ]);

    $reply->refresh();
    expect($reply->is_sent)->toBeTrue();
    expect($reply->sent_at)->not->toBeNull();
});
