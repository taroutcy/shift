<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\User;
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
        
        $schedules = $schedule->where('user_id', Auth::user()->id)->whereBetween('date', [$firstDayOfCalendar->format('Y-m-d'), $endDayOfCalendar->format('Y-m-d')])->get();
        
        while ($firstDayOfCalendar < $endDayOfCalendar) {
            $dates[] = $firstDayOfCalendar->copy();
            $firstDayOfCalendar->addDay();
        }
        
        $shifts = Shift::all();
        $workStatuses = $workStatus->get();
        
        return view('shift.calendar', compact('weeks', 'dates', 'firstDayOfMonth', 'shifts', 'schedules', 'workStatuses'));
    }
    
    public function postShift($date, Request $request)
    {
        $data = $request->post();
        
        if(isset($data['shift_id'])) {
            Schedule::updateOrCreate(
            ['user_id' => Auth::user()->id, 'date' => $date], 
            ['shift_id' => $data['shift_id'], 
             'schedule_status_id' => 1, 
             'work_status_id' => $data['work_status_id']],
            );
        } else {
            Schedule::updateOrCreate(
            ['user_id' => Auth::user()->id, 'date' => $date], 
            ['shift_id' => null, 
             'schedule_status_id' => 1, 
             'work_status_id' => $data['work_status_id']],
            );
        }
        
        return redirect()->route('shift.calendar.edit');
    }
    
    public function checkShift(int $year = null, int $month = null, User $user, Schedule $schedule)
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
        // $carbon->addMonth(2);

        $firstDayOfMonth = $carbon->copy()->firstOfMonth();
        $lastOfMonth = $carbon->copy()->lastOfMonth();

        // $firstDayOfCalendar = $firstDayOfMonth->copy()->startOfWeek();
        // $endDayOfCalendar = $lastOfMonth->copy()->endOfWeek();

        $dates = [];
        
        $dayOfMonth = $firstDayOfMonth->copy();
        
        while ($dayOfMonth <= $lastOfMonth) {
            $dates[] = $dayOfMonth->copy();
            $dayOfMonth->addDay();
        }
        
        $users = $user->where('active', true)->orderBy('department_id')->orderBy('role_id')->get();
        $schedules = $schedule->whereMonth('date', $firstDayOfMonth->copy()->month)->get();
        
        return view('shift.check', compact('dates', 'firstDayOfMonth', 'users', 'schedules'));
    }
    
    public function getConfirmShift(int $year = null, int $month = null, User $user, Schedule $schedule)
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
        // $carbon->addMonth(2);

        $firstDayOfMonth = $carbon->copy()->firstOfMonth();
        $lastOfMonth = $carbon->copy()->lastOfMonth();

        // $firstDayOfCalendar = $firstDayOfMonth->copy()->startOfWeek();
        // $endDayOfCalendar = $lastOfMonth->copy()->endOfWeek();

        $dates = [];
        
        $dayOfMonth = $firstDayOfMonth->copy();
        
        while ($dayOfMonth <= $lastOfMonth) {
            $dates[] = $dayOfMonth->copy();
            $dayOfMonth->addDay();
        }
        
        $users = $user->where('active', true)->orderBy('department_id')->orderBy('role_id')->get();
        $schedules = $schedule->whereMonth('date', $firstDayOfMonth->copy()->month)->get();
        
        return view('shift.confirm', compact('dates', 'firstDayOfMonth', 'users', 'schedules'));
    }
}
