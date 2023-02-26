@extends('layouts.app')


@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <p>
                <button type='button' class='btn-back' onClick='location.href="{{ route('user.home') }}"'>
                    &#9666; back
                </button>
            </p>
            <div class="card bg-transparent text-center border-0">
                <div class="card-header h3 text-center bg-transparent">{{ __('Register') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.register.post') }}">
                        @csrf

                        <!--個人番号-->
                        <div class="form-group row">
                            <label for="number" class="col-md-4 col-form-label text-md-right">{{ __('Number') }}</label>

                            <div class="col-md-6">
                                <input id="number" type="text" class="form-control @error('number') is-invalid @enderror" name="number" value="{{ old('number') }}" minlength="1" maxlength="10" autofocus required>
                            </div>
                        </div>
                    
                         <!--名前-->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-3">
                                <input id="last_name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" minlength="1" maxlength="10" required autocomplete="last_name" placeholder="姓">
                            </div>
                            
                            <div class="col-md-3">
                                <input id="first_name" type="text" class="form-control @error('name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" minlength="1" maxlength="10" required autocomplete="first_name" placeholder="名">
                            </div>
                        </div>
                    
                        <!--パスワード-->
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" minlength="6" maxlength="50" required autocomplete="new-password">
                            </div>
                        </div>

                        <!--パスワードの確認-->
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" minlength="6" maxlength="50" required autocomplete="new-password">
                            </div>
                        </div>

                        <!--役割-->
                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                            <div class="col-md-6">
                                <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
                                    <option value="" disabled hidden selected>-- 選択してください --</option>
                                    @foreach (App\Models\Role::all() as $role)
                                    <option value="{{ $role->id }}" @if (old('role_id') == $role->id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    
                        <!--デパ-->
                        <div class="form-group row">
                            <label for="department" class="col-md-4 col-form-label text-md-right">{{ __('Department') }}</label>

                            <div class="col-md-6">
                                <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
                                    <option value="" disabled hidden selected>-- 選択してください --</option>
                                    @foreach (App\Models\Department::all() as $department)
                                    <option value="{{ $department->id }}" @if (old('department_id') == $department->id) selected @endif>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    
                        <p class="card-text">
                            <div class="col-md-4 offset-md-4">
                                <button type="submit" class="btn btn-outline-primary">
                                    登録
                                </button>
                            </div>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection