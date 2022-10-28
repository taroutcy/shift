@extends('layouts.app')

@section('content')
<div class="container">
    <p>
        <button type='button' class='btn btn-sm btn-outline-primary' onClick='location.href="{{ route('home') }}"'>
            back
        </button>
    </p>
    <div class="col-md-2">
        <div class="row justify-content-center">
            <div class="input-group">
                <h4>
                    {{ $firstDayOfMonth->copy()->format('Y-n') }}
                </h4>
            </div>
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
                <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                {{ $user->last_name }}
                            </td>
                            @foreach($dates as $date)
                                @foreach($schedules->where('user_id', $user->id)->where('date', $date->format('Y-m-d')) as $schedule)
                                <td class="text-danger">
                                    @if($schedule->workStatus->name == '出勤')
                                        {{ $schedule->shift->name }}
                                    @elseif($schedule->workStatus->name == '有給')
                                        有
                                    @else
                                        ×
                                    @endif
                                </td>
                                @endforeach
                                
                                @forelse($schedules->where('user_id', $user->id)->where('date', $date->format('Y-m-d')) as $schedule)
                                @empty
                                <td class="text-danger">
                                    ×   
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
    
@endsection