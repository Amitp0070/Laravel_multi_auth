<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.adminlogin');
    }


    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                if (Auth::guard('admin')->user()->role != "admin") {
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.adminlogin')->with('error', 'You are not an admin');
                }
                return redirect()->route('admin.admindashboard')->with('success', 'You have Successfully logged in.');
            } else {
                return redirect()->route('admin.adminlogin')->with('error', 'Invalid email or password');
            }
        } else {
            return redirect()->route('admin.adminlogin')->withErrors($validator)->withInput();
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.adminlogin')->with('success', 'You have Successfully logged out');
    }
}
