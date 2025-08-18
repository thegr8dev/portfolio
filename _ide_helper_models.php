<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $ticket_id
 * @property string $first_name
 * @property string $last_name
 * @property string $subject
 * @property string $email
 * @property string $message
 * @property \App\InquiryStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InquiryReply> $replies
 * @property-read int|null $replies_count
 * @method static \Database\Factories\InquiryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperInquiry {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $inquiry_id
 * @property int $user_id
 * @property string $message
 * @property bool $is_sent
 * @property int|null $sent_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Inquiry $inquiry
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\InquiryReplyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InquiryReply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InquiryReply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InquiryReply query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InquiryReply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InquiryReply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InquiryReply whereInquiryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InquiryReply whereIsSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InquiryReply whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InquiryReply whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InquiryReply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InquiryReply whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperInquiryReply {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property bool $is_admin
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

