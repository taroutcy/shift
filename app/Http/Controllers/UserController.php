<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Role; 
use App\Models\Department; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(User $user) {
        return view('user.index')->with(['user' => $user]);
    }
    
    public function getEdit($id)
    {
        $user = $this->user->find($id);
        $role = Role::where('id', '=', $user->role_id)->first();
        $department = Department::where('id', '=', $user->department_id)->first();
        
        return view('user.edit', compact('user', 'role', 'department'));
    }
    
    public function postEdit($id, Request $request)
    {
        // 渡されたデータの取得
        $data = $request->post();
        
        User::where('id', '=', $id)
        ->update([
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            // 'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
            'department_id' => $data['department_id']
        ]);
        
        return redirect()->route('user.home');
    }
    
    public function getRegister()
    {
        return view('user.register');
    }
    
    public function postRegister(Request $request)
    {
        $data = $request->post();
        
        User::create([
            'number' => $data['number'],
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
            'department_id' => $data['department_id'],
        ]);
        
        return redirect()->route('user.home');
    }
    
    public function home(User $user)
    {
        return view('user.home')->with(['users' => $user->get()]);
    }
}
