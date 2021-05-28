<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Kelola Kategori";
        
        $kategori = Kategori::all();
        return view('admin.kategori.index', compact('title', 'kategori'));
    }

    public function store(Request $request)
    {
        $query = Kategori::insert([
            'nama'=> $request->nama
        ]);
        if ($query) {
            return redirect()->back()->with('success', 'Kategori berhasil ditambah');
        }else{
            return redirect()->back()->with('alert', 'Kategori gagal ditambah');
        }
    }

    public function update(Request $request)
    {
        Kategori::where('id', $request->id)
        ->update([
            'nama' => $request->nama
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diubah');
    }

    public function hapus(Request $request)
    {
        $query = Kategori::where('id', $request->id)->delete();

        if($query){
            return redirect()->back()->with('success', 'Berhasil menghapus kategori');
        }else{
            return redirect()->back()->with('alert', 'Gagal menghapus kategori');
        }
    }
}
