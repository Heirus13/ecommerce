<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
     public function index()
    {
        // Logic to retrieve cart items would go here
        return view('admin'); 
    }
}