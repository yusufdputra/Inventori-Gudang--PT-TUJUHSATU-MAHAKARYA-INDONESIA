<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Kelola Data Pengembalian Barang ";

        $barangs = Barang::all();
        $peminjaman = Peminjaman::with('barang', 'user')
        ->orderBy('created_at', 'DESC')
        ->get();
        return view('barang.pengembalian.index', compact('title', 'peminjaman', 'barangs'));
    }

    
    public function edit($id)
    {
        return Peminjaman::with('barang')->where('id', $id)->first();
    }

    public function update(Request $request)
    {
        try {
            Peminjaman::where('id', $request->id)
                ->update([
                    'pengembalian_at' => Carbon::now()
                ]);

            //kembalikan stok barang lama
            Barang::where('id', $request->id_barang)
                ->increment('stok', $request->jml_pinjam);


            return redirect()->back()->with('success', 'Pengembalian Barang berhasil dilakukan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Pengembalian Barang gagal dilakukan');
        }
    }
}
