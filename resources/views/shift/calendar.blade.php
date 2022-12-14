@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <p>
                <button type='button' class='btn-back' onClick='location.href="{{ route('home') }}"'>
                    &#9666; home
                </button>
                <h2>シフト提出</h2>
            </p>
            
            <div class="input-group">
                <div class="mr-2">
                    <button type='button' class="btn btn-sm btn-light input-group-btn" onClick='location.href="{{ route('shift.calendar.edit', 
                    ['year' => $firstDayOfMonth->copy()->subMonth()->year, 
                    'month' => $firstDayOfMonth->copy()->subMonth()->month]) }}"'>
                        <
                    </button>
                </div>
                <h4>
                    {{ $firstDayOfMonth->copy()->year }}-{{ $firstDayOfMonth->copy()->month }}
                </h4>
                <div class="ml-2">
                    <button type='button' class="btn btn-sm btn-light input-group-btn" onClick='location.href="{{ route('shift.calendar.edit', 
                    ['year' => $firstDayOfMonth->copy()->addMonth()->year, 
                    'month' => $firstDayOfMonth->copy()->addMonth()->month]) }}"'>
                        >
                    </button>
                </div>
            </div>
            <table class="table text-center">
                <thead>
                    <tr class="h5">
                        @foreach($weeks as $i => $week)
                            <th @if ($i==\Carbon\Carbon::SUNDAY) 
                                    class="text-danger"
                                @elseif ($i == \Carbon\Carbon::SATURDAY) 
                                    class="text-primary" 
                                @endif
                            >
                                {{ $week }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="">
                        
                        
                    @foreach($dates as $date)
                        @if($date->isSunday())
                            <tr>
                        @endif
                            <td class="
                                @if ($date->month != $firstDayOfMonth->month)
                                    bg-secondary text-light
                                @endif
                                "
                            >
                                <div>{{ $date->format('j') }}</div>
                                
                                    @if ($date->month == $firstDayOfMonth->month)
                                        @if(isset($schedules->where('date', date($date->format('Y-m-d')))->first()->schedule_status_id) == false)
                                            <button type="button" class="btn btn-light btn-lg text-danger" data-toggle="modal" data-target="#modal{{ $date->format('Ymd') }}" onClick="manageDispSelect({{ $schedules->where('date', date($date->format('Y-m-d')))->first()->work_status_id ?? 0 }}, {{ $date->format('Ymd') }});">
                                        @elseif(isset($schedules->where('date', date($date->format('Y-m-d')))->first()->schedule_status_id))
                                            @if($schedules->where('date', date($date->format('Y-m-d')))->first()->schedule_status_id == 1)
                                                <!--シフトが"提出状態"の場合-->
                                                <button type="button" class="btn btn-light btn-lg text-danger"  data-toggle="modal" data-target="#modal{{ $date->format('Ymd') }}" onClick="manageDispSelect({{ $schedules->where('date', date($date->format('Y-m-d')))->first()->work_status_id ?? 0 }}, {{ $date->format('Ymd') }});">
                                            @else
                                                <!--シフトが確定した場合-->
                                                <button disabled type="button" class="btn btn-light btn-lg text-primary" data-toggle="modal" data-target="#modal{{ $date->format('Ymd') }}" onClick="manageDispSelect({{ $schedules->where('date', date($date->format('Y-m-d')))->first()->work_status_id ?? 0 }}, {{ $date->format('Ymd') }});">
                                            @endif
                                        @endif
                                    @else
                                        <button disabled type="button" class="btn btn-lg text-light" data-toggle="modal" data-target="#modal{{ $date->format('Ymd') }}">
                                    @endif
                                
                                    <!--カレンダーにシフトの時間・欠勤・有給を表示-->
                                    @foreach($schedules->where('date', date($date->format('Y-m-d'))) as $schedule)
                                        @switch($schedule->work_status_id)
                                            @case($workStatuses->where('name', '出勤')->first()->id)
                                                <!--シフトの種類を表示-->
                                                {{ $schedule->shift->name }}
                                                @break
                                            <!--欠勤の場合-->
                                            @case($workStatuses->where('name', '欠勤')->first()->id)
                                                ×
                                                @break
                                            <!--有給の場合-->
                                            @case($workStatuses->where('name', '有給')->first()->id)
                                                有
                                                @break
                                        @endswitch
                                    @endforeach
                                    
                                    @forelse($schedules->where('date', date($date->format('Y-m-d'))) as $schedule)
                                    @empty
                                        ×
                                    @endforelse
                                    
                                
                                    @if ($date->month == $firstDayOfMonth->month)
                                        @if(isset($schedules->where('date', date($date->format('Y-m-d')))->first()->schedule_status_id) == false)
                                            </button>
                                        @elseif(isset($schedules->where('date', date($date->format('Y-m-d')))->first()->schedule_status_id))
                                            @if($schedules->where('date', date($date->format('Y-m-d')))->first()->schedule_status_id == 2)
                                                </button>
                                            @else
                                                </button>
                                            @endif
                                        @endif
                                    @else
                                        </button>
                                    @endif
                                
                                <!--モーダル-->
                                <div class="modal fade" id="modal{{ $date->format('Ymd') }}" role="dialog" aria-labelledby="label1" aria-hidden="true" data-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header align-text-center">
                                                <h5 class="modal-title text-dark h4">
                                                    {{ $date->format('Y/n/j') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ route('shift.calendar.post', ['date' => $date->format('Y-m-d')]) }}" name="form{{ $date->format('Ymd') }}">
                                                <div class="modal-body text-dark h6">
                                                    @csrf
                                                    <p>
                                                    @foreach($schedules->where('date', date($date->format('Y-m-d'))) as $schedule)
                                                        <label><input type="radio" name="work_status_id" value="1" onclick='$("#shift{{ $date->format('Ymd') }}").removeAttr("disabled");' @if($schedule->workStatus->name == '出勤') checked @endif>
                                                            出勤
                                                        </label>
                                                        <label><input type="radio" name="work_status_id" value="2" onclick='$("#shift{{ $date->format('Ymd') }}").attr("disabled", "disabled");' @if($schedule->workStatus->name == '欠勤') checked @endif>
                                                            欠勤
                                                        </label>
                                                    	@can('notPart')
                                                            <label><input type="radio" name="work_status_id" value="3" onclick='$("#shift{{ $date->format('Ymd') }}").attr("disabled", "disabled");' @if($schedule->workStatus->name == '有給') checked @endif>
                                                                有給
                                                            </label>
                                                        @endcan
                                                    @endforeach
                                                        
                                                        @forelse($schedules->where('date', date($date->format('Y-m-d'))) as $schedule)
                                                        @empty
                                                            <label><input type="radio" name="work_status_id" value="1" onclick='$("#shift{{ $date->format('Ymd') }}").removeAttr("disabled");'>
                                                                出勤
                                                            </label>
                                                            <label><input type="radio" name="work_status_id" value="2" onclick='$("#shift{{ $date->format('Ymd') }}").attr("disabled", "disabled");' checked>
                                                                欠勤
                                                            </label>
                                                        	@can('notPart')
                                                                <label><input type="radio" name="work_status_id" value="3" onclick='$("#shift{{ $date->format('Ymd') }}").attr("disabled", "disabled");'>
                                                                    有給
                                                                </label>
                                                            @endcan
                                                        @endforelse
                                                    </p>
                                                        
                                                    <!--シフトの時間を選択-->
                                                    <div class="row justify-content-center">
                                                        <select class="form-control w-50 text-center" style="font-size: 14px;" name="shift_id" id="shift{{ $date->format('Ymd') }}" required="required">
                                                            <option value="" disabled hidden>-- 選択してください --</option>
                                                                @foreach($shifts as $shift)
                                                                    @foreach($schedules->where('date', date($date->format('Y-m-d'))) as $schedule)
                                                                        <option value="{{ $shift->id }}" @if($shift->id == $schedule->shift_id) selected @endif> {{ $shift->name }} : {{ date('G:i', strtotime($shift->start_time)) }}-{{ date('G:i', strtotime($shift->end_time)) }}</option>
                                                                    @endforeach
                                                                    
                                                                    @forelse($schedules->where('date', date($date->format('Y-m-d'))) as $schedule)
                                                                    @empty
                                                                        <option value="{{ $shift->id }}"> {{ $shift->name }} : {{ date('G:i', strtotime($shift->start_time)) }}-{{ date('G:i', strtotime($shift->end_time)) }}</option>
                                                                    @endforelse
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                        
                                                    
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-outline-primary">OK</button>
                                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" onClick="document.form{{ $date->format('Ymd') }}.reset();">キャンセル</button>
                                                </div>
                                                    
                                                <script>
                                                    function manageDispSelect(work_status_id, date) {
                                                        let select = document.getElementById('shift' + date);
                                                        
                                                        if (work_status_id == '1') {
                                                            select.disabled = false;
                                                        } else {
                                                            select.disabled = true;
                                                        }
                                                    }
                                                    
                                                    function inShiftSlect(id) {
                                                        let select = document.getElementById('shift' + id);
                                                        
                                                        if (select.value) {
                                                           return true;
                                                        } else {
                                                            return false;
                                                        }
                                                    }
                                                </script>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @if($date->isSaturday())
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
