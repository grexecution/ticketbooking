<?php

namespace App\Models;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @mixin IdeHelperEvent
 */
class Event extends Model implements HasMedia
{
    use InteractsWithMedia;

    public const STATUS_LIVE = 'live';
    public const STATUS_HIDDEN = 'hidden';
    public const STATUS_PREVIEW = 'preview';
    public const STATUS_ENDED = 'ended';

    protected $table = 'events';

    protected $fillable = [
        'user_id',
        'program_id',
        'venue_id',
        'name',
        'artist',
        'price',
        'seat_type',
        'seat_amount',
        'active',
        'status',
        'start_date',
        'start_time',
        'doors_open_time',
        'short_desc',
        'description',
    ];

    protected $casts = [
        'active' => 'boolean',
        'start_date' => 'datetime',
        'start_time' => 'datetime',
        'doors_open_time' => 'datetime',
    ];

    protected $appends = [
        'logo',
        'partners',
        'logo_thumb_index_url',
        'logo_thumb_edit_url',
        'logo_event_url',
    ];

    /**
     * @param Media|null $media
     */
    public function registerMediaConversions(Media $media = null) : void
    {
        $this->addMediaConversion('thumb-index')
            ->width(83)
            ->height(60)
            ->sharpen(10);

        $this->addMediaConversion('thumb-edit')
            ->width(120)
            ->height(120)
            ->sharpen(10);

        $this->addMediaConversion('event-show')
            ->width(350)
            ->height(218)
            ->sharpen(10);
    }

    /**
     * @return Media|null
     */
    public function getLogoAttribute() : ? Media
    {
        return $this->getMedia('logo')->last();
    }

    public function getPartnersAttribute(): MediaCollection
    {
        return $this->getMedia('partners');
    }

    /**
     * @return string|null
     */
    public function getLogoThumbIndexUrlAttribute() : ? string
    {
        return $this->getMedia('logo')->last()?->getFullUrl('thumb-index');
    }

    /**
     * @return string|null
     */
    public function getLogoThumbEditUrlAttribute() : ? string
    {
        return $this->getMedia('logo')->last()?->getFullUrl('thumb-edit');
    }

    /**
     * @return string|null
     */
    public function getLogoEventUrlAttribute() : ? string
    {
        return $this->getMedia('logo')->last()?->getFullUrl('event-show');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function program(): HasOne
    {
        return $this->hasOne(Program::class);
    }

    public function discounts() : BelongsToMany
    {
        return $this->belongsToMany(Discount::class, 'event_discount', 'event_id', 'discount_id');
    }

    public function vouchers() : BelongsToMany
    {
        return $this->belongsToMany(Voucher::class, 'event_voucher', 'event_id', 'voucher_id');
    }

    public function vouchersExcepts() : BelongsToMany
    {
        return $this->belongsToMany(Voucher::class, 'event_voucher_excepts', 'event_id', 'voucher_id');
    }

    public function subscriptions() : BelongsToMany
    {
        return $this->belongsToMany(Subscription::class, 'event_subscription', 'event_id', 'subscription_id');
    }

    public function artists() : BelongsToMany
    {
        return $this->belongsToMany(Artist::class, 'event_artist', 'event_id', 'artist_id');
    }
}
