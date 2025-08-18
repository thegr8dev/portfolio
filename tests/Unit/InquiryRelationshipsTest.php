<?php

use App\Models\Inquiry;
use App\Models\InquiryReply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('inquiry has many replies relationship', function () {
    $inquiry = Inquiry::factory()->create();
    $user = User::factory()->create();

    // Create multiple replies for the inquiry
    $reply1 = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
        'message' => 'First reply',
    ]);

    $reply2 = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
        'message' => 'Second reply',
    ]);

    // Test the relationship
    $replies = $inquiry->replies;

    expect($replies)->toHaveCount(2);
    expect($replies->pluck('id'))->toContain($reply1->id, $reply2->id);
    expect($replies->first())->toBeInstanceOf(InquiryReply::class);
});

test('inquiry reply belongs to inquiry relationship', function () {
    $inquiry = Inquiry::factory()->create([
        'subject' => 'Test Subject',
    ]);

    $user = User::factory()->create();

    $reply = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
    ]);

    // Test the relationship
    $relatedInquiry = $reply->inquiry;

    expect($relatedInquiry)->toBeInstanceOf(Inquiry::class);
    expect($relatedInquiry->id)->toBe($inquiry->id);
    expect($relatedInquiry->subject)->toBe('Test Subject');
});

test('inquiry reply belongs to user relationship', function () {
    $inquiry = Inquiry::factory()->create();

    $user = User::factory()->create([
        'name' => 'Support Agent',
        'email' => 'support@example.com',
    ]);

    $reply = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
    ]);

    // Test the relationship
    $relatedUser = $reply->user;

    expect($relatedUser)->toBeInstanceOf(User::class);
    expect($relatedUser->id)->toBe($user->id);
    expect($relatedUser->name)->toBe('Support Agent');
    expect($relatedUser->email)->toBe('support@example.com');
});

test('inquiry can have zero replies', function () {
    $inquiry = Inquiry::factory()->create();

    // Test that an inquiry with no replies returns empty collection
    $replies = $inquiry->replies;

    expect($replies)->toHaveCount(0);
    expect($replies)->toBeEmpty();
});

test('deleting inquiry cascades to replies', function () {
    $inquiry = Inquiry::factory()->create();
    $user = User::factory()->create();

    $reply1 = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
    ]);

    $reply2 = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
    ]);

    // Verify replies exist
    expect(InquiryReply::count())->toBe(2);

    // Delete the inquiry
    $inquiry->delete();

    // Verify replies are also deleted due to cascade
    expect(InquiryReply::count())->toBe(0);
});

test('deleting user cascades to replies', function () {
    $inquiry = Inquiry::factory()->create();
    $user = User::factory()->create();

    $reply = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
    ]);

    // Verify reply exists
    expect(InquiryReply::count())->toBe(1);

    // Delete the user
    $user->delete();

    // Verify reply is also deleted due to cascade
    expect(InquiryReply::count())->toBe(0);

    // Verify inquiry still exists
    expect(Inquiry::count())->toBe(1);
});

test('inquiry reply can access inquiry properties through relationship', function () {
    $inquiry = Inquiry::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'subject' => 'Product Inquiry',
    ]);

    $user = User::factory()->create();

    $reply = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
    ]);

    // Test accessing inquiry properties through relationship
    expect($reply->inquiry->first_name)->toBe('John');
    expect($reply->inquiry->last_name)->toBe('Doe');
    expect($reply->inquiry->email)->toBe('john@example.com');
    expect($reply->inquiry->subject)->toBe('Product Inquiry');
});

test('inquiry replies are ordered by creation date', function () {
    $inquiry = Inquiry::factory()->create();
    $user = User::factory()->create();

    // Create replies with specific timestamps
    $oldReply = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
        'created_at' => now()->subDays(2),
    ]);

    $newReply = InquiryReply::factory()->create([
        'inquiry_id' => $inquiry->id,
        'user_id' => $user->id,
        'created_at' => now()->subDay(),
    ]);

    // Test that replies are returned in creation order
    $replies = $inquiry->replies()->orderBy('created_at')->get();

    expect($replies->first()->id)->toBe($oldReply->id);
    expect($replies->last()->id)->toBe($newReply->id);
});
