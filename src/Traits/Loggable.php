<?php

namespace Toneflix\LaravelPayPocket\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Toneflix\LaravelPayPocket\Models\WalletsLog;

trait Loggable
{
    public function logs(): MorphMany
    {
        return $this->morphMany(WalletsLog::class, 'loggable');
    }
}
