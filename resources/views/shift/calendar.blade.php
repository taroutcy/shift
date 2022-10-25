@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ secure_asset('css/style.css') }}">
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
                                    <button type="button" class="btn btn-link text-danger" data-toggle="modal" data-target="#modal{{ $date->format('Ymd') }}">
                                @endif
                                
                                @foreach($schedules->where('date', date($date->format('Y-m-d'))) as $schedule)
                                    @switch($schedule->work_status_id)
                                        @case($statuses->where('name', '出勤')->first()->id)
                                            {{ $schedule->shift->name }}
                                            @break
                                        @case($statuses->where('name', '欠勤')->first()->id)
                                            ×
                                            @break
                                        @case($statuses->where('name', '有給')->first()->id)
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
                                
                                <div class="modal fade" id="modal{{ $date->format('Ymd') }}" role="dialog" aria-labelledby="label1" aria-hidden="true">
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
                                                <form method="POST" action="{{ route('shift.calendar.post') }}">
                                                @csrf
                                                    <p>
                                                        <br>
                                                        <label class="workStatues"><input type="radio" name="work_status_id" value="1" onclick="checkradio(true)">出勤</label>
                                                        <label class="workStatues"><input type="radio" name="work_status_id" value="2" onclick="checkradio(false)">欠勤</label>
                                                    	@can('notPart')
                                                            <label class="workStatues"><input type="radio" name="work_status_id" value="2" onclick="checkradio(false)">有給</label>
                                                        @endcan
                                                    </p>
                                                    
                                                    <select name="shift_id">
                                                        <option value="">-- 選択してください --</option>
                                                            @foreach($shifts as $shift)
                                                                @foreach($schedules->where('date', date($date->format('Y-m-d'))) as $schedule)
                                                                  asfd  <option value="{{ $shift->id }}" @if($shift->id == $schedule->shift_id) selected @endif> {{ $shift->name }}: {{ date('G:i', strtotime($shift->start_time)) }}- {{ date('G:i', strtotime($shift->end_time)) }}</option>
                                                                @endforeach
                                                                
                                                                @forelse($schedules->where('date', date($date->format('Y-m-d'))) as $schedule)
                                                                @empty
                                                                    <option value="{{ $shift->id }}"> {{ $shift->name }}: {{ date('G:i', strtotime($shift->start_time)) }}- {{ date('G:i', strtotime($shift->end_time)) }}</option>
                                                                @endforelse
                                                            @endforeach
                                                    </select>

                                                    <script>
                                                        function checkradio( disp ) {
                                                           document.getElementById('shifts').disabled = disp;
                                                        }
                                                    </script>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">OK</button>
                                            </div>
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