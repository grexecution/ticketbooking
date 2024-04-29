<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperArtist
 */
class Artist extends Model
{
    protected $table = 'artists';

    protected $fillable = ['name'];

    public function events() : BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_artist', 'artist_id', 'event_id');
    }
}
