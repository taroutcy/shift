@extends('layouts.app')

@section('content')
<div class="container"> 
    <div><h2>従業員管理</h2></div>
        <div class="card-deck">
            <div class="card">
                <div class="card-header"><h3>社員</h3></div>
                <div class="card-body">
                    @foreach($users->where('role_id', '=', '1') as $user)
                    <a href="/users/edit/{{$user->id}}"><div>{{ $user->last_name }}{{ $user->first_name }}</div></a>
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="card-header"><h3>社保</h3></div>
                <div class="card-body">
                    @foreach($users->where('role_id', '=', '2') as $user)
                    <a href="/users/edit/{{$user->id}}"><div>{{ $user->last_name }}{{ $user->first_name }}</div></a>
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="card-header"><h3>アルバイト</h3></div>
                <div class="card-body">
                    @foreach($users->where('role_id', '=', '3') as $user)
                    <a href="/users/edit/{{$user->id}}"><div>{{ $user->last_name }}{{ $user->first_name }}</div></a>
                    @endforeach
                </div>
        </div>
    </div>
</div>

@endsection