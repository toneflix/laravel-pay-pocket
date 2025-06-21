<?php

namespace ToneflixCode\LaravelPayPocket\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use ToneflixCode\LaravelPayPocket\Models\WalletsLog;

trait Loggable
{
    public function logs(): MorphMany
    {
        return $this->morphMany(WalletsLog::class, 'loggable');
    }
}
