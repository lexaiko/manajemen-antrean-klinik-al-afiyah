<?php

namespace App\Services;

use App\Models\JadwalPegawai;
use Carbon\Carbon;

class CalendarService
{
    public function generateCalendarData($weekDays)
{
    $calendarData = [];
    $timeRange = (new TimeService)->generateTimeRange(
        config('app.calendar.start_time', '08:00'),
        config('app.calendar.end_time', '18:00')
    );

    $jadwalData = JadwalPegawai::with(['pegawai', 'role'])
        ->get()
        ->groupBy('hari');

    foreach ($timeRange as $time) {
        $timeText = $time['start'] . ' - ' . $time['end'];
        $calendarData[$timeText] = [];

        foreach ($weekDays as $day) {
            $schedule = $jadwalData->get($day, collect())
                ->first(function ($item) use ($time) {
                    return $item->jam_mulai === $time['start'];
                });

            if ($schedule) {
                $start = Carbon::parse($schedule->jam_mulai);
                $end = Carbon::parse($schedule->jam_selesai);

                // 1. PERBAIKI URUTAN PERHITUNGAN
                $difference = $start->diffInMinutes($end); // <-- Urutan benar

                // 2. HANDLE JADWAL OVERNIGHT
                if ($difference < 0) {
                    $end->addDay();
                    $difference = $start->diffInMinutes($end);
                }

                // 3. PASTIKAN ROWSPAN POSITIF
                $rowspan = max($difference / 30, 1); // Minimal 1 slot

                $calendarData[$timeText][$day] = [
                    'pegawai' => $schedule->pegawai->name,
                    'role' => $schedule->role->nama_role,
                    'rowspan' => $rowspan
                ];
            } else {
                $isOccupied = $jadwalData->get($day, collect())
                    ->contains(function ($item) use ($time) {
                        return $time['start'] >= $item->jam_mulai &&
                               $time['end'] <= $item->jam_selesai;
                    });

                $calendarData[$timeText][$day] = $isOccupied ? 0 : 1;
            }
        }
    }

    return $calendarData;
}
}

