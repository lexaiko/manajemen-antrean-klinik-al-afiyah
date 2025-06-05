<?php

namespace App\Http\Controllers;

use App\Models\JadwalPegawai;
use App\Services\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class KalenderController extends Controller
{
    public function index(CalendarService $calendarService)
    {
        $weekDays = JadwalPegawai::WEEK_DAYS;
        $calendarData = $calendarService->generateCalendarData(array_keys($weekDays));

        // dd(compact('weekDays', 'calendarData'));
        Log::info('Calendar Data Structure:', $calendarData);
        return view('admin.kalender', compact('weekDays', 'calendarData'));
    }
}
