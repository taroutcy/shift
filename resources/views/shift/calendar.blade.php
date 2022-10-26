@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ secure_asset('css/style.css') }}">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <p>
                <button type='button' class='btn btn-sm btn-outline-primary' onClick='location.href="{{ route('home') }}"'>
                    <!--&lt;back&gt;-->
                    back
                </button>
            </p>
            <div class="input-group">
                <div class="mr-2">
                    <a href="{{ route('shift.calendar', 
                    ['year' => $firstDayOfMonth->copy()->subMonth()->year, 
                    'month' => $firstDayOfMonth->copy()->subMonth()->month]) }}">
                        <
                    </a>
                </div>
                <h4>
                    {{ $firstDayOfMonth->copy()->year }}-{{ $firstDayOfMonth->copy()->month }}
                </h3>
                <div class="ml-2">
                    <a href="{{ route('shift.calendar', 
                    ['year' => $firstDayOfMonth->copy()->addMonth()->year, 
                    'month' => $firstDayOfMonth->copy()->addMonth()->month]) }}">
                        >
                    </a>
                </div>
            </div>
            <table class="table text-center">
                <thead>
                    <tr>
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
                                    <button type="button" class="btn btn-link text-danger" data-toggle="modal" data-target="#modal{{ $date->format('Ymd') }}" onClick="manageDispSelect({{ App\Models\Schedule::all()->where('date', date($date->format('Y-m-d')))->first()->work_status_id ?? 0 }}, {{ $date->format('Ymd') }});">
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
                                            有給
                                            @break
                                    @endswitch
                                @endforeach
                                
                                @forelse($schedules->where('date', date($date->format('Y-m-d'))) as $schedule)
                                @empty
                                    ×
                                @endforelse
                                    
                                @if ($date->month == $firstDayOfMonth->month)
                                    </button>
                                @endif
                                
                                <!--モーダル-->
                                <div class="modal fade" id="modal{{ $date->format('Ymd') }}" role="dialog" aria-labelledby="label1" aria-hidden="true" data-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header align-text-center">
                                                <h5 class="modal-title text-dark">
                                                    {{ $date->format('Y/n/j') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-dark">
                                                <form method="POST" action="{{ route('shift.calendar.post') }}" name="modal{{ $date->format('Ymd') }}">
                                                @csrf
                                                    <p>
                                                        <br>
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
                                                    <select name="shift_id" id="shift{{ $date->format('Ymd') }}">
                                                        <option value=""  disabled selected>-- 選択してください --</option>
                                                            @foreach($shifts as $shift)
                                                                @foreach($schedules->where('date', date($date->format('Y-m-d'))) as $schedule)
                                                                    <option value="{{ $shift->id }}" @if($shift->id == $schedule->shift_id) selected @endif> {{ $shift->name }}: {{ date('G:i', strtotime($shift->start_time)) }}-{{ date('G:i', strtotime($shift->end_time)) }}</option>
                                                                @endforeach
                                                                
                                                                @forelse($schedules->where('date', date($date->format('Y-m-d'))) as $schedule)
                                                                @empty
                                                                    <option value="{{ $shift->id }}"> {{ $shift->name }}: {{ date('G:i', strtotime($shift->start_time)) }}-{{ date('G:i', strtotime($shift->end_time)) }}</option>
                                                                @endforelse
                                                            @endforeach
                                                    </select>
                                                    
                                                    <script>
                                                        function manageDispSelect(work_status_id, date) {
                                                            let select = document.getElementById('shift' + date);
                                                            
                                                            if (work_status_id == '1') {
                                                                select.disabled = false;
                                                            } else {
                                                                select.disabled = true;
                                                            }
                                                        }
                                                    </script>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-primary" value="OK">
                                                <input type="reset" class="btn btn-secondary" data-dismiss="modal" value="キャンセル" onClick="document.modal{{ $date->format('Ymd') }}.reset();">
                                            </div>
                                            
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
