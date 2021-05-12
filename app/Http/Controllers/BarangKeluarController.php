<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Kelola Data Barang Keluar";

        $barangs = Barang::all();
        $barang_klr = BarangKeluar::with('barang')->orderBy('created_at', 'DESC')->get();
        return view('barang.keluar.index', compact('title', 'barang_klr', 'barangs'));
    }

    public function store(Request $request)
    {
        try {
            $query = BarangKeluar::insert([
                'id_barang' => $request->id_barang,
                'stok_keluar' => $request->stok_keluar,
                'lokasi' => $request->lokasi,
                'pengambil' => $request->pengambil,
                'fungsi' => $request->fungsi,
                'created_at' => Carbon::now(),

            ]);

            //jumlahkan barang yg sudah ada
            Barang::where('id', $request->id_barang)
                ->decrement('stok', $request->stok_keluar);
            if ($query) {
                return redirect()->back()->with('success', 'Barang Keluar berhasil ditambah');
            } else {
                return redirect()->back()->with('alert', 'Barang Keluar gagal ditambah');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Barang Keluar gagal ditambah' );
        }
    }

    public function edit($id)
    {
        return BarangKeluar::with('barang')->where('id', $id)->first();
    }

    public function update(Request $request)
    {
        try {
            BarangKeluar::where('id', $request->id)
                ->update([
                    'id_barang' => $request->id_barang,
                    'stok_keluar' => $request->stok_keluar,
                    'lokasi' => $request->lokasi,
                    'pengambil' => $request->pengambil,
                    'fungsi' => $request->fungsi,
                ]);

            //jumlahkan barang yg sudah ada
            Barang::where('id', $request->id_barang)
                ->increment('stok', $request->stok_keluar);

            Barang::where('id', $request->id_barang)
                ->decrement('stok', $request->old_stok_keluar);

            return redirect()->back()->with('success', 'Barang Keluar berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Barang Keluar gagal diubah'.$th);
        }
    }

    public function hapus(Request $request)
    {

        $query = BarangKeluar::where('id', $request->id)->delete();
        //jumlahkan barang yg sudah ada
        Barang::where('id', $request->id_barang)
            ->increment('stok', $request->stok_keluar);
        if ($query) {
            return redirect()->back()->with('success', 'Berhasil menghapus Barang Keluar');
        } else {
            return redirect()->back()->with('alert', 'Gagal menghapus Barang Keluar');
        }
    }
}
