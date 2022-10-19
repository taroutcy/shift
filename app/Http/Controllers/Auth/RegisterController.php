<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/user/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    
    protected $rules = [
        'number' => ['required', 'string', 'min:10', 'max:10', 'unique:users'], 
        'last_name' => ['required', 'string', 'max:10'], 
        'first_name' => ['required', 'string', 'max:10'], 
        'password' => ['required', 'string', 'min:6', 'confirmed'],
        'department_id' => ['required'],
        'role_id' => ['required'],
    ];
    
    protected $messages = [
        'number.required' => '個人番号を入力してください', 
        'number.min' => '10桁の個人番号を入力してください',
        'number.max' => '10桁の個人番号を入力してください',
        'number.unique' => 'その個人番号は既に登録されています',
        'last_name.required' => '苗字を入力してください', 
        'last_name.max' => '10文字以上で入力してください',
        'first_name.required' => '苗字を入力してください', 
        'first_name.max' => '10文字以上で入力してください',
        'password.required' => 'パスワードを入力してください', 
        'password.min' => 'パスワードは6文字以上で入力してください', 
        'password.confirmed' => '入力されたパスワードが一致しません', 
        'role_id.required' => '契約状況を選択してください', 
        'department_id.required' => 'デパを選択してください',
    ];
    
    protected function validator(array $data)
    {
        return Validator::make($data, $this->rules, $this->messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'number' => $data['number'],
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
            'department_id' => $data['department_id'],
        ]);
    }
}
