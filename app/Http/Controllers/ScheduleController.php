<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Schedule;
use App\Models\WorkStatus;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function getShift(int $year = null, int $month = null, Schedule $schedule, WorkStatus $workStatus)
    {
        $weeks = ['日', '月', '火', '水', '木', '金', '土'];

        $carbon = new Carbon();
        $carbon->locale('ja_JP');

        if ($year) {
            $carbon->setYear($year);
        }
        if ($month) {
            $carbon->setMonth($month);
        }
        
        $carbon->setDay(1);
        $carbon->setTime(0, 0);

        $firstDayOfMonth = $carbon->copy()->firstOfMonth();
        $lastOfMonth = $carbon->copy()->lastOfMonth();

        $firstDayOfCalendar = $firstDayOfMonth->copy()->startOfWeek();
        $endDayOfCalendar = $lastOfMonth->copy()->endOfWeek();

        $dates = [];
        
        while ($firstDayOfCalendar < $endDayOfCalendar) {
            $dates[] = $firstDayOfCalendar->copy();
            $firstDayOfCalendar->addDay();
        }
        
        $shifts = Shift::all();
        $schedules = $schedule->where('user_id', Auth::user()->id)->get();
        $workStatuses = $workStatus->get();

        return view('shift.calendar', compact('weeks', 'dates', 'firstDayOfMonth', 'shifts', 'schedules', 'workStatuses'));
    }
}
