@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p>
                <button type='button' class='btn btn-sm btn-outline-primary' onClick='location.href="{{ route('home') }}"'>
                    <!--&lt;back&gt;-->
                    back
                </button>
            </p>
            <div class="input-group">
                <div class="mr-2">
                    <a href="{{ route('schedule.calendar', 
                    ['year' => $firstDayOfMonth->copy()->subMonth()->year, 
                    'month' => $firstDayOfMonth->copy()->subMonth()->month]) }}">
                        <
                    </a>
                </div>
                <h4>
                    {{ $firstDayOfMonth->copy()->year }}-{{ $firstDayOfMonth->copy()->month }}
                </h3>
                <div class="ml-2">
                    <a href="{{ route('schedule.calendar', 
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
                                @if ($date->month != $firstDayOfMonth->copy()->month)
                                    bg-secondary text-light
                                @endif
                                "
                            >
                                <div>{{ $date->format('j') }}</div>
                                @if ($date->month == $firstDayOfMonth->copy()->month)
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modal1">
                                        test
                                    </button>
                                    <div class="modal fade" id="modal1" role="dialog" aria-labelledby="label1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header align-text-center">
                                                    <h5 class="modal-title text-dark">
                                                        {{ $date->format('n/j') }}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-dark">
                                                    <form method="POST" action="{{ route('schedule.calendar.post') }}">
                                                    @csrf
                                                        <select>
                                                        @foreach($shifts as $shift)
                                                                <option value={{ $shift->id }}> {{ $shift->name }}: {{ substr($shift->start_time, 0, 5) }}-{{ substr($shift->end_time, 0, 5) }}</option>
                                                        @endforeach
                                                        </select>
                                                        
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">OK</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    test
                                @endif
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
<style>
</style>


@endsection