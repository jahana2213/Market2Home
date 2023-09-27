<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('register');
    }
    public function login(Request $request)
    {
        return view('login');
    }
    public function home(Request $request)
    {
        return view('home');
    }
}
