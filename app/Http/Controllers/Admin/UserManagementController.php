<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $roles = Role::pluck('display_name','id')->toArray();

        $users = User::paginate(20)->withQueryString();

        return view('admin.user.index')
            ->with('roles', $roles)
            ->with('users', $users);
    }


    public function search(Request $request)
    {

        $db = new User;

        if ( $request->filled('username') )
            $db = $db->where('username', 'like', '%'.$request->input('username').'%');

        if ( $request->filled('role') ){

            $role = Role::find($request->input('role'));
            $db = $db->whereRoleIs($role->name);
        }

        $data = $db->paginate(20)->withQueryString();

        return view('admin.user.search_result')
            ->with('users', $data);
    }

    public function create(Request $request)
    {
        $roles = Role::pluck('display_name','id')->toArray();

        return view('admin.user.create')
            ->with('roles', $roles);
    }

    public function store(Request $request)
    {
        $rules = [
            'username'              => 'required|unique:App\Models\User,username',
            'fullname'              => 'required',
            'role'                  => 'required',
            'office'                => 'required',
            'password'              => 'required|min:4|confirmed',
            'password_confirmation' => 'required'
        ];


        $messages = [
            'username.not_exists'            => 'User already exists',
            'password_confirmation.required' => 'This field is required',
            'password.confirmed'             => 'Password did not match',
        ];

        $this->validate($request, $rules, $messages);

        $user = new User;
        $user->username = $request->username;
        $user->fullname = $request->fullname;
        $user->office = $request->office?? 'ICT';
        $user->password = bcrypt($request->password);
        $user->save();

        $role = Role::find($request->role);
        $user->attachRole($role);

        return redirect()->route('admin.user.index')
            ->with('success', 'User created successfully');
    }


    public function delete(Request $request)
    {
        $user = User::find($request->user_id);
        $user->delete();

        return '  ';
    }

}
