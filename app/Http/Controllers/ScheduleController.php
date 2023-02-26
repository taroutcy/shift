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
    
    public function __construct() {
        $this->weeks = ['日', '月', '火', '水', '木', '金', '土'];
    }
    
    public function makeFirstAndLastDay($year, $month, $increace) {
        
        $carbon = new Carbon();     // インスタインスを生成
        $carbon->locale('ja_JP');   // 場所を日本に設定
        
        // 年と月が指定されている場合
        if ($year && $month) {
            $carbon->setYear($year);    // 年を設定
            $carbon->setMonth($month);  // 月を設定
        } elseif($increace) {
            $carbon->addMonth();
        }
        
        $carbon->setDay(1);     // 〇月1日に設定
        $carbon->setTime(0, 0); // 0時0分に設定
        
        $firstDayOfMonth = $carbon->copy()->firstOfMonth(); // 月の初日の月日を算出
        $lastDayOfMonth = $carbon->copy()->lastOfMonth();   // 月の最終日の月日を算出
        
        return array($firstDayOfMonth, $lastDayOfMonth);
    }
    
    public function makeDates($firstDay, $lastDay) {
        $dates = [];
        
        while ($firstDay < $lastDay) {
            $dates[] = $firstDay->copy();
            $firstDay->addDay();
        }
        
        return $dates;
    }
    
    public function getShift(int $year = null, int $month = null, Schedule $schedule, WorkStatus $workStatus)
    {
        $weeks = $this->weeks;  // 曜日名を取得
        
        // $month月の初日と最終日を取得
        list($firstDayOfMonth, $lastDayOfMonth) = $this->makeFirstAndLastDay($year, $month, true);

        // $month月におけるカレンダーの初日と最終日を取得
        $firstDayOfCalendar = $firstDayOfMonth->copy()->startOfWeek(); 
        $lastDayOfCalendar = $lastDayOfMonth->copy()->endOfWeek();
        
        // カレンダー内の日付を全て取得
        $dates = $this->makeDates($firstDayOfCalendar->copy(), $lastDayOfCalendar->copy());
        
        // ログインしたユーザのカレンダー内のシフトを全て取得
        $schedules = $schedule->where('user_id', Auth::user()->id)
        ->whereBetween('date', [$firstDayOfCalendar->copy()->format('Y-m-d'), $lastDayOfCalendar->copy()->format('Y-m-d')])->get();
        
        // 登録できるシフトと提出可能な出勤条件を取得
        $shifts = Shift::all(); 
        $workStatuses = WorkStatus::all();
        
        return view('shift.calendar', compact('weeks', 'dates', 'firstDayOfMonth', 'shifts', 'schedules', 'workStatuses'));
    }
    
    public function postShift($date, Request $request)
    {
        $data = $request->post();       // postされたデータを取得
        $user_id = Auth::user()->id;    // ログインユーザのidを取得
        
        // 出勤 欠勤 有給でswitchする
        switch($data['work_status_id']) {
            // 出勤の場合
            case 1:
                // 既に$dateにおけるシフトが
                // 登録されていた場合 -> udpate
                // 登録されていなかった場合 -> create
                Schedule::updateOrCreate(
                ['user_id' => $user_id, 'date' => $date], 
                ['shift_id' => $data['shift_id'], 
                 'schedule_status_id' => 1, 
                 'work_status_id' => 1]
                );
                break;
            // 欠勤の場合
            case 2:
                // シフトが登録されていた場合は削除
                if(Schedule::where('date', $date)->where('user_id', $user_id)->exists()) {
                    Schedule::where('date', $date)
                    ->where('user_id', $user_id)
                    ->delete();
                }
                break;
            // 有給の場合
            case 3:
                // 既に$dateにおけるシフトが
                // 登録されていた場合 -> udpate
                // 登録されていなかった場合 -> create
                Schedule::updateOrCreate(
                    ['user_id' => $user_id, 'date' => $date], 
                    ['shift_id' => null, 
                     'schedule_status_id' => 1, 
                     'work_status_id' => 3]
                );
                break;
        }
        
        
        return redirect()->route('shift.calendar.edit');
    }
    
    public function checkShift(int $year = null, int $month = null, User $user, Schedule $schedule)
    {
        $weeks = $this->weeks;  // 曜日名を取得

        // $month月の初日と最終日を取得
        list($firstDayOfMonth, $lastDayOfMonth) = $this->makeFirstAndLastDay($year, $month, false);

        // カレンダー内の日付を全て取得
        $dates = $this->makeDates($firstDayOfMonth->copy(), $lastDayOfMonth->copy());
        
        // アクティブユーザをデパと契約状況で昇順に並び替えて取得
        $users = $user->where('active', true)->orderBy('department_id')->orderBy('role_id')->get();
        
        // $year年$month月の提出されたシフトを全て取得
        $schedules = $schedule
                     ->whereYear('date', $firstDayOfMonth->copy()->year)
                     ->whereMonth('date', $firstDayOfMonth->copy()->month)->get();
        
        return view('shift.check', compact('dates', 'firstDayOfMonth', 'users', 'schedules'));
    }
    
    public function getConfirmShift(int $year = null, int $month = null, User $user, Schedule $schedule)
    {
        $weeks = $this->weeks;  // 曜日名を取得

        // $month月の初日と最終日を取得
        list($firstDayOfMonth, $lastDayOfMonth) = $this->makeFirstAndLastDay($year, $month, true);
        
        // カレンダー内の日付を全て取得
        $dates = $this->makeDates($firstDayOfMonth->copy(), $lastDayOfMonth->copy());
        
        // アクティブユーザをデパと契約状況で昇順に並び替えて取得
        $users = $user->where('active', true)->orderBy('department_id')->orderBy('role_id')->get();
        
        // $year年$month月の提出されたシフトを全て取得
        $schedules = $schedule
                     ->whereYear('date', $firstDayOfMonth->copy()->year)
                     ->whereMonth('date', $firstDayOfMonth->copy()->month)->get();

        $shifts = Shift::all(); // 登録できるシフトの時間帯を取得
        
        return view('shift.confirm', compact('dates', 'firstDayOfMonth', 'users', 'schedules', 'shifts'));
    }
    
    public function allConfirmShift($year,$month, Request $request)
    {
        // シフトをロックするボタンが押された場合
        if($request->has('confirm')) {
            
            // 日時取得
            list($firstDayOfMonth, $lastDayOfMonth) = $this->makeFirstAndLastDay($year, $month, false);
            
            // 各ユーザごとに回す
            foreach(User::all() as $user) {
                
                // 月の最初の日
                $date = $firstDayOfMonth->copy();
                
                // 月の初日から最終日まで回す
                while($date <= $lastDayOfMonth) {
                    $date_fmt = $date->format('Y-m-d');
                    if(Schedule::where('user_id', $user->id)->where('date', $date_fmt)->exists()){
                        Schedule::where('user_id', $user->id)->where('date', $date_fmt)
                        ->update(['schedule_status_id' => 2]);
                    } else {
                        Schedule::where('user_id', $user->id)->where('date', $date_fmt)
                        ->create(
                        ['user_id' => $user->id,
                         'schedule_status_id' => 2,
                         'work_status_id' => 2,
                         'date' => $date_fmt
                        ]);
                    }
                    $date->addDay(1);
                }
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
        $data = $request->post();    // postされたデータを取得
        
         // 出勤 欠勤 有給でswitchする
        switch($data['work_status_id']) {
            // 出勤の場合
            case 1:
                Schedule::updateOrCreate(
                ['user_id' => $id, 'date' => $date], 
                ['shift_id' => $data['shift_id'], 
                 'schedule_status_id' => 2, 
                 'work_status_id' => 1]
                );
                break;
                
            // 欠勤の場合
            case 2:
                // 何もしない
                break;
                
            // 有給の場合
            case 3:
                Schedule::updateOrCreate(
                    ['user_id' => $id, 'date' => $date], 
                    ['shift_id' => null, 
                     'schedule_status_id' => 2, 
                     'work_status_id' => 3]
                );
                break;
        }
        
        return redirect()->route('shift.confirm.get', ['year' => $year, 'month' => $month]);
    }
}
