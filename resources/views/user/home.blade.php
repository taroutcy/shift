@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<div class="container-fluid"> 
    <div class="row justify-content-center">
        <div class="col-md-5">
        <p>
            <button type='button' class='btn-back' onClick='location.href="{{ route('home') }}"'>
                &#9666; home
            </button>
        </p>
        <div class='input-group'>
            <h2 class='mr-3'>従業員管理</h2>
            <span class="input-group-btn">
                <button type='button' class='btn btn-sm btn-outline-danger' onClick='location.href="{{ route('user.register.get') }}"'>
                    {{ __('Register') }}
                </button>
            </span>
        </div>
            <p>
                <div class="card-deck">
                    <div class="card border-0 bg-transparent">
                        <div class="card-header bg-transparent h3">社員</div>
                        <div class="card-body h5">
                            @foreach($users->where('role_id', 1)->sortByDesc('active') as $user)
                                <p>
                                    @if($user->active == true)
                                        <a class="text-body" href="{{ route('user.edit.get', ['id' => $user->id]) }}">
                                    @else
                                        <font class="text-muted">
                                    @endif
                                    
                                    {{ $user->last_name }} {{ $user->first_name }}
                                     
                                     @if($user->active == true)
                                        </a>
                                    @else
                                        </font>
                                    @endif
                                 </p>
                            @endforeach
                        </div>
                    </div>
                    <div class="card border-0 bg-transparent">
                        <div class="card-header bg-transparent h3">社保</div>
                        <div class="card-body h5">
                            @foreach($users->where('role_id', 2)->sortByDesc('active') as $user)
                                <p>
                                    @if($user->active == true)
                                        <a class="text-body" href="{{ route('user.edit.get', ['id' => $user->id]) }}">
                                    @else
                                        <font class="text-muted">
                                    @endif
                                    
                                    {{ $user->last_name }} {{ $user->first_name }}
                                     
                                     @if($user->active == true)
                                        </a>
                                    @else
                                        </font>
                                    @endif
                                 </p>
                            @endforeach
                        </div>
                    </div>
                    <div class="card border-0 bg-transparent">
                        <div class="card-header bg-transparent h3">アルバイト</div>
                        <div class="card-body h5">
                           @foreach($users->where('role_id', 3)->sortByDesc('active') as $user)
                                <p>
                                    @if($user->active == true)
                                        <a class="text-body" href="{{ route('user.edit.get', ['id' => $user->id]) }}">
                                    @else
                                        <font class="text-muted">
                                    @endif
                                    
                                    {{ $user->last_name }} {{ $user->first_name }}
                                     
                                     @if($user->active == true)
                                        </a>
                                    @else
                                        </font>
                                    @endif
                                 </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </p>
        </div>
    </div>
</div>

@endsection