<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ControlRoomController;
use App\Http\Controllers\Admin\UnitOfficeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getLogin(Request $request)
    {
        return view('users.login')
            ->with('page_title', 'Login');

    }


    public function postLogin(Request $request)
    {
        $input = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if ( auth()->attempt($input) ) {

            Log::info('Admin Login from:'.$request->server('REMOTE_ADDR'), ['context', $input['username']]);

            if (session()->has('ctrl_intended_url')){
                return redirect(session()->pull('ctrl_intended_url'));
            }

            return redirect()->route('user.dashboard');

        } else {
            Log::info('Admin Access Attempt from :'.request()->server('REMOTE_ADDR'), ['context', $input]);
            return redirect()->route('user.getLogin')
                ->with('message', 'Your User ID/password combination was incorrect')
                ->withInput();
        }

    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('user.getLogin');
    }


    public function getChangePassword()
    {
        return view('users.change_password')
            ->with('user', auth()->user());
    }


    public function postUpdatePassword(Request $request)
    {

        $rules = [
            'current_password'          => 'required|min:6|current_password',
            'new_password'              => 'required|min:6|confirmed',
            'new_password_confirmation' => 'required',
        ];


        $messages = array(
            'new_password_confirmation.required' => 'This field is required',
            'new_password.confirmed'             => 'Password did not match',
        );

        $this->validate($request, $rules, $messages);

        //update user password
        $user           = auth()->user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->back()
            ->with('message', 'Password has been changed successfully');



    }

    public function dashboard()
    {
        if ( auth()->user()->hasRole('UnitOffice') ){
            return app(UnitOfficeController::class)->getDashboard();
        }

        if ( auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Operator') ){
            return app(AdminController::class)->dashboard();
        }

        if ( auth()->user()->hasRole('PhotoCollector') ){
            return app(ControlRoomController::class)->getDashboard();
        }


        /*if ( auth()->user()->hasRole("Dean Office") ) {
            return redirect()->route('dean.dashboard');// for dean office
        } elseif ( auth()->user()->hasRole("Unit Office") ) {
            return redirect()->route('unit.dashboard');// for dean office
        } else {
            return redirect()->route('user.dashboard'); // for ICT Users
        }*/


    }


}
