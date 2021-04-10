<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Login";
        return view('home', compact('title'));
    }

    public function auth()
    {
        $title = "Dashboard";

        if (Auth::check()) {
            return view('home', compact('title'));
        }
        return view('auth.login', compact('title'));
    }
}
