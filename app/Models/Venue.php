<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @mixin IdeHelperVenue
 */
class Venue extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'address',
        'zipcode',
        'city',
        'country',
        'email',
        'phone',
        'website',
        'description',
    ];

    protected $appends = [
        'logo',
        'logo_thumb_index_url',
        'logo_thumb_edit_url',
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
    }

    /**
     * @return Media|null
     */
    public function getLogoAttribute() : ? Media
    {
        return $this->getMedia('logo')->last();
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

    public function events() : BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
