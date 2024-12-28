<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Make sure to import the User model

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Adjust the path as necessary
    }

    /**
     * Handle a login request to the application.
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

        // Check if the user exists by email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // If the user exists, check if the password is correct
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Redirect to the home page or intended page
                return redirect()->intended('/');
            } else {
                // Password is incorrect
                return redirect()->back()->withErrors([
                    'password' => 'The provided password is incorrect.'
                ])->withInput();
            }
        } else {
            // If the user does not exist (incorrect email)
            return redirect()->back()->withErrors([
                'login' => 'No account found with that email address.'
            ])->withInput();
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/'); // Redirect to home after logout
    }
}
