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
                    <h2>シフト確認</h2>
                    <div class="ml-5 h4">
                        <font class="text-primary mr-2">確定</font>
                        <font class="text-danger">未確定</font>
                    </div>
                </div>
            </p>
            <div class="input-group">
                <div class="mr-2">
                    <button type='button' class="btn btn-sm btn-light input-group-btn" onClick='location.href="{{ route('shift.check', 
                    ['year' => $firstDayOfMonth->copy()->subMonth()->year, 
                    'month' => $firstDayOfMonth->copy()->subMonth()->month]) }}"'>
                        <
                    </button>
                </div>
                <h4>
                    {{ $firstDayOfMonth->copy()->year }}-{{ $firstDayOfMonth->copy()->month }}
                </h4>
                <div class="ml-2">
                    <button type='button' class="btn btn-sm btn-light input-group-btn" onClick='location.href="{{ route('shift.check', 
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
                                <td class="h5">
                                    <font class="h6">
                                        {{ $user->last_name }}
                                    </font>
                                </td>
                                @foreach($dates as $date)
                                    @foreach($schedules->where('user_id', $user->id)->where('date', $date->format('Y-m-d')) as $schedule)
                                    <td class="h5
                                    @if($schedule->scheduleStatus->name == '提出')
                                        text-danger
                                    @elseif($schedule->scheduleStatus->name == '決定')
                                        text-primary
                                    @endif
                                    ">
                                        @if($schedule->workStatus->name == '出勤')
                                            {{ $schedule->shift->name }}
                                        @elseif($schedule->workStatus->name == '有給')
                                            有
                                        @else
                                            <font class="h6">
                                                ×
                                            </font>
                                        @endif
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