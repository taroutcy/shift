@extends('layouts.app')

@section('content')
<div class="container"> 
    <div class="row justify-content-center">
        
        <div class="col-md-9">
            <p>
                <button type='button' class='btn btn-sm btn-outline-primary' onClick='location.href="{{ route('home') }}"'>
                    back
                </button>
            </p>
            <div class='row input-group'>
                    <h2 class='mr-4'>従業員管理</h2>
                    <span class="input-group-btn">
                        <button type='button' class='btn btn-sm btn-outline-success' onClick='location.href="{{ route('user.register.get') }}"'>
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
                                <a href="{{ route('user.edit.get', ['id' => $user->id]) }}">
                                    <p
                                    @if($user->active == false)
                                        class="text-muted"
                                    @endif
                                         >{{ $user->last_name }} {{ $user->first_name }}
                                     </p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="card border-0 bg-transparent">
                        <div class="card-header bg-transparent h3">社保</div>
                        <div class="card-body h5">
                            @foreach($users->where('role_id', 2)->sortByDesc('active') as $user)
                                <a href="{{ route('user.edit.get', ['id' => $user->id]) }}">
                                    <p
                                    @if($user->active == false)
                                        class="text-muted"
                                    @endif
                                         >{{ $user->last_name }} {{ $user->first_name }}
                                     </p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="card border-0 bg-transparent">
                        <div class="card-header bg-transparent h3">アルバイト</div>
                        <div class="card-body h5">
                           @foreach($users->where('role_id', 3)->sortByDesc('active') as $user)
                                <a href="{{ route('user.edit.get', ['id' => $user->id]) }}">
                                    <p
                                    @if($user->active == false)
                                        class="text-muted"
                                    @endif
                                         >{{ $user->last_name }} {{ $user->first_name }}
                                     </p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </p>
        </div>
    </div>
</div>

@endsection