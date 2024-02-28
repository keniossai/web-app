<?php

namespace App\Traits;

use Carbon\Carbon;

trait UserTrait {

    public function formatTimezone($date)
    {
        $timezone = optional(auth()->user())->timezone ?? config('app.timezone');
        $formatdate = Carbon::parse($date)->timezone($timezone);

        return $formatdate;
    }
}
