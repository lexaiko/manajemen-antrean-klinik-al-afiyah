<?php

namespace App\Services;

use Carbon\Carbon;

class TimeService
{
    public function generateTimeRange($from, $to)
    {
        $time = Carbon::parse($from);
        $endTime = Carbon::parse($to);
        $timeRange = [];

        while ($time < $endTime) {
            $start = $time->format('H:i');
            $time->addMinutes(30);
            $end = $time->format('H:i');

            $timeRange[] = [
                'start' => $start,
                'end' => $end
            ];
        }

        return $timeRange;
    }
}
