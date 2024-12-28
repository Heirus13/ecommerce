<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ensure the user is authenticated
        $admin = Auth::guard('admin')->user();
        
        // Pass any necessary data to the view
        return view('admindashboard', compact('admin')); // No 'admin.' prefix needed
    }
}