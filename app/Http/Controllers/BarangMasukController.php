<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Kelola Data Barang Masuk";

        $barangs = Barang::all();
        $barang_msk = BarangMasuk::with('barang')->orderBy('created_at', 'DESC')->get();
        return view('barang.masuk.index', compact('title', 'barang_msk', 'barangs'));
    }

    public function store(Request $request)
    {
        try {
            $query = BarangMasuk::insert([
                'id_barang' => $request->id_barang,
                'stok_masuk' => $request->stok_masuk,
                'lokasi' => $request->lokasi,
                'created_at' => Carbon::now(),

            ]);

            //jumlahkan barang yg sudah ada
            Barang::where('id', $request->id_barang)
                ->increment('stok', $request->stok_masuk);
            if ($query) {
                return redirect()->back()->with('success', 'Barang Masuk berhasil ditambah');
            } else {
                return redirect()->back()->with('alert', 'Barang Masuk gagal ditambah');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Barang Masuk gagal ditambah');
        }
    }

    public function edit($id)
    {
        return BarangMasuk::with('barang')->where('id', $id)->first();
    }


    public function update(Request $request)
    {
        try {
            BarangMasuk::where('id', $request->id)
                ->update([
                    'id_barang' => $request->id_barang,
                    'stok_masuk' => $request->stok_masuk,
                    'lokasi' => $request->lokasi,
                ]);

            //jumlahkan barang yg sudah ada
            Barang::where('id', $request->id_barang)
                ->decrement('stok', $request->old_stok_masuk);

            Barang::where('id', $request->id_barang)
                ->increment('stok', $request->stok_masuk);

            return redirect()->back()->with('success', 'Barang Masuk berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Barang Masuk gagal diubah');
        }
    }

    public function hapus(Request $request)
    {

        $query = BarangMasuk::where('id', $request->id)->delete();
        //jumlahkan barang yg sudah ada
        Barang::where('id', $request->id_barang)
            ->decrement('stok', $request->stok_masuk);
        if ($query) {
            return redirect()->back()->with('success', 'Berhasil menghapus Barang Masuk');
        } else {
            return redirect()->back()->with('alert', 'Gagal menghapus Barang Masuk');
        }
    }
}
