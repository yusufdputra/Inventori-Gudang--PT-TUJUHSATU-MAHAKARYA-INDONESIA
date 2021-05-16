<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
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
            $barangs = Barang::orderBy('stok', 'ASC')->where('stok', '<', 100)->limit(5)->get();
            $masuks = BarangMasuk::orderBy('created_at', 'DESC')->limit(5)->get();
            $keluars = BarangKeluar::orderBy('created_at', 'DESC')->limit(5)->get();
            return view('home', compact('title', 'barangs', 'masuks', 'keluars'));
        }
        return view('auth.login', compact('title'));
    }
}
