<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Kelola Data Peminjaman Barang ";

        $barangs = Barang::all();
        $peminjaman = Peminjaman::with('barang', 'user')
        ->whereNull('pengembalian_at')
        ->orderBy('created_at', 'DESC')
        ->get();
        return view('barang.peminjaman.index', compact('title', 'peminjaman', 'barangs'));
    }

    public function store(Request $request)
    {
        try {
            $query = Peminjaman::insert([
                'nama_peminjam' => $request->nama_peminjam,
                'id_barang' => $request->id_barang,
                'estimasi' => $request->estimasi,
                'jml_pinjam' => $request->jml_pinjam,
                'fungsi' => $request->fungsi,
                'created_at' => Carbon::now(),
            ]);

            //kurangi barang yg sudah ada
            Barang::where('id', $request->id_barang)
                ->decrement('stok', $request->jml_pinjam);
            if ($query) {
                return redirect()->back()->with('success', 'Peminjaman Barang berhasil ditambah');
            } else {
                return redirect()->back()->with('alert', 'Peminjaman Barang gagal ditambah');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Peminjaman Barang gagal ditambah');
        }
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
                    'nama_peminjam' => $request->nama_peminjam,
                    'id_barang' => $request->id_barang,
                    'estimasi' => $request->estimasi,
                    'jml_pinjam' => $request->jml_pinjam,
                    'fungsi' => $request->fungsi,
                ]);

            //kembalikan stok barang lama
            Barang::where('id', $request->old_id_barang)
                ->increment('stok', $request->old_stok_pinjam);

            // kurangi stok barang yg dipilih
            Barang::where('id', $request->id_barang)
                ->decrement('stok', $request->jml_pinjam);

            return redirect()->back()->with('success', 'Peminjaman Barang berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Peminjaman Barang gagal diubah');
        }
    }

    public function hapus(Request $request)
    {

        $query = Peminjaman::where('id', $request->id)->delete();
        //jumlahkan barang yg sudah ada
        Barang::where('id', $request->id_barang)
            ->increment('stok', $request->jml_pinjam);
        if ($query) {
            return redirect()->back()->with('success', 'Berhasil menghapus Barang Masuk');
        } else {
            return redirect()->back()->with('alert', 'Gagal menghapus Barang Masuk');
        }
    }
}
