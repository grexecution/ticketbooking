<?php

namespace App\Models;

use App\Models\SeatPlan\EventSeatPlanCategory;
use App\Models\SeatPlan\SeatPlan;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;

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
        'active_bookings',
        'total_tickets',
        'has_bought_tickets',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            $event->slug = Str::slug($event->artist . ' ' . $event->name);
        });

        static::updating(function ($event) {
            $event->slug = Str::slug($event->artist . ' ' . $event->name);
        });
    }

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
            ->width(557)
            ->height(350)
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

    public function getActiveBookingsAttribute() : int
    {
        $countBookings = 0;

        $this->orders->each(function (Order $order) use (&$countBookings) {
            $countORderTickets = $order->tickets
                ->where('is_paid', true)
                ->where('is_refunded', false)
                ->where('is_cancelled', false)
                ->count();
            $countBookings += $countORderTickets;
        });

        return $countBookings;
    }

    public function getTotalTicketsAttribute()
    {
        return $this->seatPlanCategories->sum('places');
    }

    public function getHasBoughtTicketsAttribute() : bool
    {
        $this->load(['orders.tickets']);

        return $this->orders
            ->flatMap(fn ($order) => $order->tickets)
            ->where('is_paid', true)
            ->where('is_cancelled', false)
            ->where('is_refunded', false)
            ->count() > 0;
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

    public function seatPlanCategories() : HasMany
    {
        return $this
            ->hasMany(EventSeatPlanCategory::class)
            ->whereNull('subscription_id');
    }

    public function seatPlanCategoriesForSubscriptions() : HasMany
    {
        return $this
            ->hasMany(EventSeatPlanCategory::class)
            ->whereNotNull('subscription_id');
    }

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function bookings() : HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function checkins() : HasMany
    {
        return $this->hasMany(Checkin::class);
    }

    public function loadSeatPlanWithCategories() : void
    {
        $this->load(['seatPlanCategories']);
        if ($this->seatPlanCategories->count() > 0) {
            $seatPlainId = $this->seatPlanCategories->first()->seat_plan_id;
            $seatPlan = SeatPlan::query()->find($seatPlainId);
            $seatPlan->seat_plan_categories = $this->seat_plan_categories;
            $this->seat_plan = $seatPlan;
        }
    }

    public function loadSeatPlanWithCategoriesForSubscriptions() : void
    {
        $this->load(['seatPlanCategoriesForSubscriptions']);
        if ($this->seatPlanCategoriesForSubscriptions->count() > 0) {
            $seatPlainId = $this->seatPlanCategoriesForSubscriptions->first()->seat_plan_id;
            $seatPlan = SeatPlan::query()->find($seatPlainId);
            $seatPlan->seat_plan_categories_for_subscriptions = $this->seat_plan_categories;
            $this->seat_plan = $seatPlan;
        }
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->artist . ' ' . $this->name);
    }
}
