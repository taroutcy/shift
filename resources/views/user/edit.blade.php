@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p>
                <button type='button' class='btn btn-sm btn-outline-primary' onClick='location.href="{{ route('user.home') }}"'>
                    back
                </button>
            </p>
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.edit.post', ['id' => $user->id])}}">
                        @csrf

                        <!--個人番号-->
                        <div class="form-group row">
                            <label for="number" class="col-md-4 col-form-label text-md-right">{{ __('Number') }}</label>

                            <div class="col-md-6">
                                <input id="number" type="text" class="form-control @error('number') is-invalid @enderror" name="number" value="{{ $user->number }}" minlength="10" maxlength="10" required autofocus autocomplete="number">
                                
                                <!--@error('number')-->
                                <!--    <span class="invalid-feedback" role="alert">-->
                                <!--        <strong>{{ $message }}</strong>-->
                                <!--    </span>-->
                                <!--@enderror-->
                            </div>
                        </div>
                        
                         <!--名前-->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-3">
                                <input id="last_name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}" minlength="1" maxlength="10" required autocomplete="last_name">
                            </div>
                            
                            <div class="col-md-3">
                                <input id="first_name" type="text" class="form-control @error('name') is-invalid @enderror" name="first_name" value="{{ $user->first_name }}" minlength="1" maxlength="10" required autocomplete="first_name">
                            </div>
                        </div>
                        
                        <!--パスワード-->
                        <!--<div class="form-group row">-->
                        <!--    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>-->

                        <!--    <div class="col-md-6">-->
                        <!--        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">-->

                        <!--        @error('password')-->
                        <!--            <span class="invalid-feedback" role="alert">-->
                        <!--                <strong>{{ $message }}</strong>-->
                        <!--            </span>-->
                        <!--        @enderror-->
                        <!--    </div>-->
                        <!--</div>-->

                        <!--パスワードの確認-->
                        <!--<div class="form-group row">-->
                        <!--    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>-->

                        <!--    <div class="col-md-6">-->
                        <!--        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">-->
                        <!--    </div>-->
                        <!--</div>-->

                        <!--役割-->
                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                            <div class="col-md-6">
                                <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
                                    @foreach (App\Models\Role::all() as $role)
                                        <option value="{{ $role->id }}" @if ($user->role_id == $role->id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!--デパ-->
                        <div class="row">
                            <label for="department" class="col-md-4 col-form-label text-md-right">{{ __('Department') }}</label>

                            <div class="col-md-6">
                                <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
                                    @foreach (App\Models\Department::all() as $department)
                                    <option value="{{ $department->id }}" @if ($user->department_id == $department->id) selected @endif>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!--更新-->
                        <div class="row justify-content-center">
                            <!--<div class="col-md-6 offset-md-4">-->
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            <!--</div>-->
                        </div>
                        
                        <!--削除-->
                        <!--<div class="form-group row mb-0">-->
                        <!--    <div class="col-md-6 offset-md-4"  style="display:inline-flex">-->
                        <!--        <form action="" method="post" class="col-md-6 offset-md-3">-->
                        <!--            @csrf-->
                        <!--            @method('delete')-->
                        <!--            <input type="submit" value="{{ __('Delete')}}" class="btn btn-danger" onclick='return confirm("削除しますか？");'>-->
                        <!--        </form>-->
                                
                        <!--        <form action="" method="post" class="col-md-6 offset-md-3">-->
                        <!--            @csrf-->
                        <!--            @method('delete')-->
                        <!--            <input type="submit" value="{{ __('Delete')}}" class="btn btn-danger" onclick='return confirm("削除しますか？");'>-->
                        <!--        </form>-->
                        <!--    </div>-->
                        <!--</div>-->
                                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
