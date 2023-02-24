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
                            <button type="submit" name='confirm' class="btn btn-outline-primary" style="border:none;">ロック</button>
                            <button type="submit" name='reset' class="btn btn-outline-danger" style="border:none;">解除</button>
                            <button type="button" class="btn btn-outline-info" style="border:none;" data-bs-toggle="tooltip" data-bs-placement="top" data-html="true" title="ロック: 提出を停止. 解除: 提出を許可" disabled>
                              info
                            </button>
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
                                            <button type="button" class="btn btn-outline-light text-primary" style="border:none;" data-toggle="modal" data-target="#modal{{ $user->id }}-{{ $date->format('Ymd') }}" onClick="manageDispSelect({{ $schedule->work_status_id ?? 0 }}, {{ $user->id }}{{ $date->format('Ymd') }});">
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
                                        <!--モーダルウィンドウ start-->
                                        <div class="modal fade" id="modal{{ $user->id }}-{{ $date->format('Ymd') }}" role="dialog" aria-hidden="true" data-backdrop="static">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header align-text-center">
                                                        <h4 class="modal-title text-dark">
                                                            {{ $date->format('Y/n/j') }}
                                                            form{{ $user->id }}-{{ $date->format('Ymd') }}
                                                        </h4>
                                                    </div>
                                                    <form method="POST" action="{{ route('shift.confirm.change', ['id' => $user->id, 'year' => $firstDayOfMonth->copy()->year, 'month' => $firstDayOfMonth->copy()->month, 'date' => $date->format('Y-m-d')]) }}" name="form{{ $user->id }}-{{ $date->format('Ymd') }}">
                                                        @csrf
                                                        <div class="modal-body text-dark h6">
                                                            <p>
                                                                <label><input type="radio" name="work_status_id" value="1" onclick='$("#shift{{ $user->id }}{{ $date->format('Ymd') }}").removeAttr("disabled");' @if($schedule->workStatus->name == '出勤') checked @endif>
                                                                    出勤
                                                                </label>
                                                                <label><input type="radio" name="work_status_id" value="2" onclick='$("#shift{{ $user->id }}{{ $date->format('Ymd') }}").attr("disabled", "disabled");' @if($schedule->workStatus->name == '欠勤') checked @endif>
                                                                    欠勤
                                                                </label>
                                                            	@can('notPart')
                                                                    <label><input type="radio" name="work_status_id" value="3" onclick='$("#shift{{ $user->id }}{{ $date->format('Ymd') }}").attr("disabled", "disabled");' @if($schedule->workStatus->name == '有給') checked @endif>
                                                                        有給
                                                                    </label>
                                                                @endcan
                                                            </p>
                                                                
                                                            <!--シフトの時間を選択-->
                                                            <div class="row justify-content-center">
                                                                <select class="form-control w-50 text-center" style="font-size: 14px;" name="shift_id" id="shift{{ $user->id }}{{ $date->format('Ymd') }}" required="required">
                                                                    <option value="" disabled hidden>-- 選択してください --</option>
                                                                    @foreach($shifts as $shift)
                                                                        <option value="{{ $shift->id }}" @if($shift->id == $schedule->shift_id) selected @endif> {{ $shift->name }} : {{ date('G:i', strtotime($shift->start_time)) }}-{{ date('G:i', strtotime($shift->end_time)) }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-outline-primary">OK</button>
                                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" onClick="document.form{{ $user->id }}-{{ $date->format('Ymd') }}.reset();">キャンセル</button>
                                                        </div>
                                                            
                                                        <script src="{{ asset('js/func.js') }}"></script>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--モーダルウィンドウ end-->
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