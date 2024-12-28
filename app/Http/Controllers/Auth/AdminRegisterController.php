<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin; // Use the Admin model
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class AdminRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.adminregister');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($admin = $this->create($request->all())));

        // Optionally, log the user in after registration
        // Auth::login($admin);

        return redirect()->route('admin.register')->with('success', 'Your account has been successfully created!');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:admins,name', // Check against admins table
            'email' => 'required|string|email|max:255|unique:admins,email', // Check against admins table
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        return Admin::create([ // Use Admin model here
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}