@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card bg-transparent text-center border-0">
                
                <div class="card-header bg-transparent h2">{{ __('Login') }}</div>

                <div class="card-body bg-transparent">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="form-group row card-text">
                            <label for="number" class="col-md-4 col-form-label text-md-right"><font class="h6">{{ __('Number') }}</font></label>

                            <div class="col-md-5">
                                <input id="number" type="text" class="form-control @error('number') is-invalid @enderror" name="number" minlength="10" maxlength="10" required>

                                @error('number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row card-text">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><font class="h6">{{ __('Password') }}</font></label>

                            <div class="col-md-5">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--<div class="form-group row">-->
                        <!--    <div class="col-md-5 offset-md-4">-->
                        <!--        <div class="form-check">-->
                        <!--            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>-->

                        <!--            <label class="form-check-label" for="remember">-->
                        <!--                {{ __('Remember Me') }}-->
                        <!--            </label>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->

                        <p class="card-text">
                            <div class="col-md-4 offset-md-4">
                                <button type="submit" class="btn btn-outline-primary">
                                    go
                                </button>

                                <!--@if (Route::has('password.request'))-->
                                <!--    <a class="btn btn-link" href="{{ route('password.request') }}">-->
                                <!--        {{ __('Forgot Your Password?') }}-->
                                <!--    </a>-->
                                <!--@endif-->
                            </div>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
