<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
