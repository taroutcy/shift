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
        return view('users/index')->with(['user' => $user]);
    }
    
    public function getEdit($id)
    {
        $user = $this->user->find($id);
        $role = Role::where('id', '=', $user->role_id)->first();
        $department = Department::where('id', '=', $user->department_id)->first();
        return view('users.edit', compact('user', 'role', 'department'));
    }
    
    public function postEdit($id, Request $request)
    {
        // 渡されたデータの取得
        $data = $request->post();
        
        User::where('id', '=', $id)
        ->update([
            'number' => $data['number'], 
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            // 'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
            'department_id' => $data['department_id']
        ]);
        
        return redirect('/users/home');
    }
    
    public function home(User $user)
    {
        return view('users/home')->with(['users' => $user->get()]);
    }
}
