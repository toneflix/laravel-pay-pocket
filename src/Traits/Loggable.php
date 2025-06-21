<?php

namespace ToneflixCode\LaravelPayPocket\Traits;

use ToneflixCode\LaravelPayPocket\Models\WalletsLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Loggable
{
    public function logs(): MorphMany
    {
        return $this->morphMany(WalletsLog::class, 'loggable');
    }
}
