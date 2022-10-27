@extends('layouts.app')

@section('content')
<div class="container"> 
    <p>
        <button type='button' class='btn btn-sm btn-outline-primary' onClick='location.href="{{ route('home') }}"'>
            back
        </button>
    </p>
    <div class='row input-group'>
            <h2 class='mr-4'>従業員管理</h2>
            <span class="input-group-btn">
                <button type='button' class='btn btn-sm btn-outline-primary' onClick='location.href="{{ route('user.register.get') }}"'>
                    {{ __('Register') }}
                </button>
            </span>
    </div>
    <div class="card-deck">
        <div class="card">
            <div class="card-header"><h3>社員</h3></div>
            <div class="card-body">
                @foreach($users->where('role_id', 1)->sortByDesc('active') as $user)
                    <a href="{{ route('user.edit.get', ['id' => $user->id]) }}">
                        @if($user->active == true)
                            <div>{{ $user->last_name }}{{ $user->first_name }}</div>
                        @else
                            <div class="text-muted">{{ $user->last_name }}{{ $user->first_name }}</div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h3>社保</h3></div>
            <div class="card-body">
                @foreach($users->where('role_id', 2)->sortByDesc('active') as $user)
                    <a href="{{ route('user.edit.get', ['id' => $user->id]) }}">
                        @if($user->active == true)
                            <div>{{ $user->last_name }}{{ $user->first_name }}</div>
                        @else
                            <div class="text-muted">{{ $user->last_name }}{{ $user->first_name }}</div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h3>アルバイト</h3></div>
            <div class="card-body">
               @foreach($users->where('role_id', 3)->sortByDesc('active') as $user)
                    <a href="{{ route('user.edit.get', ['id' => $user->id]) }}">
                        @if($user->active == true)
                            <div>{{ $user->last_name }}{{ $user->first_name }}</div>
                        @else
                            <div class="text-muted">{{ $user->last_name }}{{ $user->first_name }}</div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection