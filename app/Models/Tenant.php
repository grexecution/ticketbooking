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
        'stripe_fee',
    ];

    /**
     * @param Media|null $media
     */
    public function registerMediaConversions(Media $media = null) : void
    {
        $this->addMediaConversion('thumb')
            ->width(120)
            ->height(120)
            ->sharpen(10);
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
