<?php

namespace App\Models;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @mixin IdeHelperTenant
 */
class Tenant extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'company',
        'stripe_key',
        'stripe_secret',
        'stripe_account_id',
        'stripe_connected',
        'stripe_fee',
    ];

    protected $appends = [
        'logo',
        'avatar_url',
        'logo_thumb_index_url',
        'logo_thumb_edit_url',
    ];

    /**
     * @param Media|null $media
     */
    public function registerMediaConversions(Media $media = null) : void
    {
        $this->addMediaConversion('avatar')
            ->width(252)
            ->height(167)
            ->sharpen(10);

        $this->addMediaConversion('thumb-index')
            ->width(83)
            ->height(60)
            ->sharpen(10);

        $this->addMediaConversion('thumb-edit')
            ->width(120)
            ->height(120)
            ->sharpen(10);
    }

    /**
     * @return Media|null
     */
    public function getLogoAttribute() : ? Media
    {
        return $this->getMedia('logo')->last();
    }

    /**
     * @return Media|null
     */
    public function getAvatarUrlAttribute() : ? string
    {
        return $this->getMedia('logo')->last()?->getFullUrl('avatar');
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

    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    public function venues()
    {
        return collect();
    }

    public function events()
    {
        return collect();
    }
}
