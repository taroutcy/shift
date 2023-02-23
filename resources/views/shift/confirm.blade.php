@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <p>
                <button type='button' class='btn-back' onClick='location.href="{{ route('home') }}"'>
                    &#9666; home
                </button>
                <div style="display:flex; align-items:flex-end;">
                    <h2>シフト作成</h2>
                    <form method="POST" action="{{ route('shift.confirm.all', 
                        ['year' => $firstDayOfMonth->copy()->year,
                         'month' => $firstDayOfMonth->copy()->month]) }}">
                        @csrf
                        <div class="ml-4 h2 btn-group-toggle">
                            <button type="submit" name='confirm' class="btn btn-outline-primary">確定</button>
                            <button type="submit" name='reset' class="btn btn-outline-danger">リセット</button>
                        </div>
                    </form>
                </div>
            </p>
            <div class="input-group">
                <div class="mr-2">
                    <button type='button' class="btn btn-sm btn-light input-group-btn" onClick='location.href="{{ route('shift.confirm.get', 
                    ['year' => $firstDayOfMonth->copy()->subMonth()->year, 
                    'month' => $firstDayOfMonth->copy()->subMonth()->month]) }}"'>
                        <
                    </button>
                </div>
                <h4>
                    {{ $firstDayOfMonth->copy()->year }}-{{ $firstDayOfMonth->copy()->month }}
                </h4>
                <div class="ml-2">
                    <button type='button' class="btn btn-sm btn-light input-group-btn" onClick='location.href="{{ route('shift.confirm.get', 
                    ['year' => $firstDayOfMonth->copy()->addMonth()->year, 
                    'month' => $firstDayOfMonth->copy()->addMonth()->month]) }}"'>
                        >
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-center table-hover table-striped"  style="table-layout:fixed;">
                    <thead>
                        <tr>
                            <th scope="col" style="width:90px; ">名前</th>
                            @foreach($dates as $date)
                                <th scope="col" style="width:35px;">
                                    {{ $date->format('j') }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="table-borderless">
                            @foreach($users as $user)
                            <tr>
                                <td class="align-middle h5">
                                    <font class="h6">
                                        {{ $user->last_name }}
                                    </font>
                                </td>
                                @foreach($dates as $date)
                                    @foreach($schedules->where('user_id', $user->id)->where('date', $date->format('Y-m-d')) as $schedule)
                                    <td class="flex justify-center align-middle" >
                                        <div class="d-flex justify-content-center">
                                        @if($schedule->scheduleStatus->name == '提出')
                                            <font class="text-danger">
                                        @elseif($schedule->scheduleStatus->name == '決定')
                                            <button type="button" class="btn btn-outline-light text-primary">
                                        @endif
                                        
                                            @if($schedule->workStatus->name == '出勤')
                                                {{ $schedule->shift->name }}
                                            @elseif($schedule->workStatus->name == '有給')
                                                有
                                            @else
                                                <font class="h6">
                                                    ×
                                                </font>
                                            @endif
                                            
                                        @if($schedule->scheduleStatus->name == '提出')
                                            </font>
                                        @elseif($schedule->scheduleStatus->name == '決定')
                                                </button>
                                        @endif
                                        </div>
                                    </td>
                                    @endforeach
                                    
                                    @forelse($schedules->where('user_id', $user->id)->where('date', $date->format('Y-m-d')) as $schedule)
                                    @empty
                                    <td class="text-danger h5">
                                        <font class="h6">
                                                ×
                                        </font>
                                    </td>
                                    
                                    @endforelse
                                    
                                    
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    
@endsection