<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperProgram
 */
class Program extends Model
{
    protected $table = 'programs';
    protected $fillable = ['name'];

    public function events() : BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
