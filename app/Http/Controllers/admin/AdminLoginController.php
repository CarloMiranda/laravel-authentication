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

    // Authenticate the admin user
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
                // Get the authenticated admin user
                $admin = Auth::guard('admin')->user();

                // Check if the admin has the role '2'
                if ($admin->role == 1) {
                    // Redirect to the admin dashboard if authorized
                    return redirect()->route('admin.dashboard');
                } else {
                    // Logout the admin and redirect with an error if not authorized
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error', 'You are not authorized to access the admin panel.');
                }
            } else {
                // Redirect back to the admin login page with an error if authentication fails
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
