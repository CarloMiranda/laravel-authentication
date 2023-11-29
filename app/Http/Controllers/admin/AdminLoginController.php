<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    // Display the admin login form
    public function index()
    {
        return view('admin.login');
    }

    // Handle authentication attempt for admin login
    public function authenticate(Request $request)
    {
        // Validate the user input (email and password)
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if validation passes
        if ($validator->passes()) {
            // Attempt to authenticate the admin user
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                // Redirect to the admin dashboard upon successful authentication
                return redirect()->route('admin.dashboard');
            } else {
                // Redirect back to the admin login page with an error message if authentication fails
                return redirect()->route('admin.login')->with('error', 'Either Email/Password is incorrect');
            }
        } else {
            // Redirect back to the admin login page with validation errors and user input
            return redirect()->route('admin.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }
}

