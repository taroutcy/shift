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
    public function makeCarbon($year, $month) {
        
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
        
        return $carbon;
    }
    
    public function getShift(int $year = null, int $month = null, Schedule $schedule, WorkStatus $workStatus)
    {
        $weeks = ['日', '月', '火', '水', '木', '金', '土'];

        $carbon = $this->makeCarbon($year, $month);

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
        } else if($data['work_status_id'] == 2 && Schedule::where('date', $date)->where('user_id', Auth::user()->id)->exists()) {
                Schedule::where('date', $date)
                ->where('user_id', Auth::user()->id)
                ->delete();
            
        }
        
        return redirect()->route('shift.calendar.edit');
    }
    
    public function checkShift(int $year = null, int $month = null, User $user, Schedule $schedule)
    {
        $weeks = ['日', '月', '火', '水', '木', '金', '土'];

        $carbon = $this->makeCarbon($year, $month);

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
        $schedules = $schedule
                     ->whereYear('date', $firstDayOfMonth->copy()->year)
                     ->whereMonth('date', $firstDayOfMonth->copy()->month)->get();
        
        return view('shift.check', compact('dates', 'firstDayOfMonth', 'users', 'schedules'));
    }
    
    public function getConfirmShift(int $year = null, int $month = null, User $user, Schedule $schedule)
    {
        $weeks = ['日', '月', '火', '水', '木', '金', '土'];

        $carbon = $this->makeCarbon($year, $month);

        $firstDayOfMonth = $carbon->copy()->firstOfMonth();
        $lastOfMonth = $carbon->copy()->lastOfMonth();

        $dates = [];
        
        $dayOfMonth = $firstDayOfMonth->copy();
        
        while ($dayOfMonth <= $lastOfMonth) {
            $dates[] = $dayOfMonth->copy();
            $dayOfMonth->addDay();
        }
        
        $shifts = Shift::all();
        $users = $user->where('active', true)->orderBy('department_id')->orderBy('role_id')->get();
        $schedules = $schedule->whereYear('date', $firstDayOfMonth->copy()->year)->whereMonth('date', $firstDayOfMonth->copy()->month)->get();
        
        return view('shift.confirm', compact('dates', 'firstDayOfMonth', 'users', 'schedules', 'shifts'));
    }
    
    public function allConfirmShift($year,$month, Request $request)
    {
        // シフトをロックするボタンが押された場合
        if($request->has('confirm')) {
            
            // 日時取得
            $carbon = $this->makeCarbon($year, $month);
            
            $firstDayOfMonth = $carbon->copy()->firstOfMonth();
            $lastOfMonth = $carbon->copy()->lastOfMonth();
            
            // 欠勤以外のカラムを保存
            $schedules_exit = Schedule::whereYear('date', $year)->whereMonth('date', $month)->get();
            
            // 各ユーザごとに回す
            foreach(User::all() as $user) {
                
                // 月の最初の日
                $date = $firstDayOfMonth->copy();
                
                // 月の初日から最終日まで回す
                while($date <= $lastOfMonth) {
                    // この月のカラムを全て"欠勤+提出済み"にする
                    Schedule::where('user_id', $user->id)->where('date', $date->format('Y-m-d'))
                    ->updateOrCreate(
                    ['user_id' => $user->id,
                     'date' => $date->format('Y-m-d')],
                    ['shift_id' => null, 
                     'schedule_status_id' => 2, 
                     'work_status_id' => 2,
                    ]);
                    $date->addDay(1);
                }
            }
            
            // 保存した欠勤以外のデータを上書きする
            foreach($schedules_exit as $schedule) {
                Schedule::where('user_id', $schedule->user_id)
                ->where('date', $schedule->date)
                ->update(
                ['shift_id' => $schedule->shift_id,
                 'work_status_id' => $schedule->work_status_id,
                ]);
            }
            
        } 
        
        // 解除ボタンが押された場合
        if ($request->has('reset')) {
            // 欠勤のカラムを削除
            Schedule::whereYear('date', '=', $year)
            ->whereMonth('date', '=', $month)
            ->where('work_status_id', 2)
            ->delete();
            
            // $year年$month月のデータを変更可能にする
            Schedule::whereYear('date', '=', $year)
            ->whereMonth('date', '=', $month)
            ->update(['schedule_status_id' => 1]);
        }
        
        return redirect()->route('shift.confirm.get', ['year' => $year, 'month' => $month]);
    }
    
    public function changeConfirmShift($id, $year, $month, $date, Request $request)
    {
        
        $data = $request->post();
        
        // シフトが登録される場合
        if(isset($data['shift_id'])) {
            Schedule::updateOrCreate(
            ['user_id' => $id, 'date' => $date], 
            ['shift_id' => $data['shift_id'], 
             'schedule_status_id' => 2, 
             'work_status_id' => $data['work_status_id']],
            );
        } else {
            // 欠勤は登録しない
            if($data['work_status_id'] != 2)
            Schedule::updateOrCreate(
            ['user_id' => $id, 'date' => $date], 
            ['shift_id' => null, 
             'schedule_status_id' => 2, 
             'work_status_id' => $data['work_status_id']],
            );
        }
        
        return redirect()->route('shift.confirm.get', ['year' => $year, 'month' => $month]);
    }
}
