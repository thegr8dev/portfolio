<?php

namespace App\Models;

use App\InquiryStatus;
use App\Observers\InquiryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(InquiryObserver::class)]
/**
 * @mixin IdeHelperInquiry
 */
class Inquiry extends Model
{
    /** @use HasFactory<\Database\Factories\InquiryFactory> */
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'first_name',
        'last_name',
        'subject',
        'email',
        'message',
        'status',
    ];

    protected $casts = [
        'status' => InquiryStatus::class,
    ];

    /**
     * @return Attribute<string, never>
     */
    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->first_name} {$this->last_name}"
        );
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'ticket_id';
    }

    /**
     * Get all replies for this inquiry.
     *
     * @return HasMany<InquiryReply, $this>
     */
    public function replies(): HasMany
    {
        return $this->hasMany(InquiryReply::class);
    }
}
