@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
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
            <table class="table table-bordered text-center">
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
                <tbody>
                    @foreach($dates as $date)
                        @if($date->isSunday())
                            <tr>
                        @endif
                        <td
                            @if ($date->month != $firstDayOfMonth->copy()->month)
                                class="bg-secondary text-light"
                            @endif
                        >
                            <a 
                            @if ($date->month == $firstDayOfMonth->copy()->month)
                                class="text-dark" href=#
                            @endif
                            >
                                {{ $date->format('j') }}
                                
                            </a>
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