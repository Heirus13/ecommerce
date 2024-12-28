<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin; // Ensure the Admin model is imported

class AdminLoginController extends Controller
{
    /**
     * Show the admin login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.adminlogin'); // Path to your admin login view
    }

    /**
     * Handle a login request for admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to log the admin in
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Redirect to the admin dashboard
            return redirect()->intended('/admindashboard'); // Admin dashboard path
        }

        // If login fails, redirect back with an error message
        return redirect()->back()->withErrors([
            'email' => 'No account found with that email address or incorrect password.',
        ])->withInput();
    }

    /**
     * Log the admin out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/adminlogin'); 
    }
}