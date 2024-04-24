<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Program extends Model
{
    protected $table = 'programs';
    protected $fillable = ['name'];

    public function events() : BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
