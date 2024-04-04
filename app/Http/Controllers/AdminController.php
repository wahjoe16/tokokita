<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data=$request->all();
            // echo "<pre>"; print_r($data); die();

            $rules=[
                'email' =>'required|email|max:255',
                'password' =>'required|max:30'
            ];

            $customMessage=[
                'email.required' =>'Email is required',
                'email.email' =>'Valid email is required',
                'password.required' =>'Password is required'
            ];

            $this->validate($request, $rules, $customMessage);

            if (Auth::guard('admin')->attempt(
                [
                    'email' => $data['email'],
                    'password' => $data['password']
                ]
            )) {
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->back()->with('error_message','Email or password is incorrect');
            }
        }
        return view('admin.login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function updatePassword(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data=$request->all();
            // check if current password is correct
            if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
                // check if new password and confirm password are matcing
                if ($data['new_pwd']==$data['confirm_pwd']) {
                    // Update password
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_pwd'])]);
                    return redirect()->back()->with('success_message','Password updated successfully');
                }else {
                    return redirect()->back()->with('error_message','New password and confirm password are not match!');
                }
            }else{
                return redirect()->back()->with('error_message','Old Password is Incorrect!');
            }
        }
        return view('admin.update_password');
    }

    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();
        if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
