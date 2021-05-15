<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Restok;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RestokController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $title = "Permintaan Restok Barang";
        $barang = Barang::all();
        $restok = Restok::with('barang')->orderBy('terpenuhi_stok', 'ASC')->get();
        return view('restok.index', compact('restok', 'title', 'barang'));
    }

    public function store(Request $request)
    {
        $query = Restok::insert([
            'id_barang' => $request->id,
            'permintaan_stok' => $request->permintaan_stok,
            'created_at' => Carbon::now(),
        ]);
        if ($query) {
            return redirect()->back()->with('success', 'Permintaan Restok Barang Berhasil Diajukan');
        } else {
            return redirect()->back()->with('alert', 'Permintaan Restok Barang Gagal Diajukan');
        }
    }

    public function edit($id)
    {
        return Restok::with('barang')->where('id', $id)->first();
    }

    public function update(Request $request)
    {
        try {
            Restok::where('id', $request->id)
                ->update([
                    'id_barang' => $request->id_barang,
                    'permintaan_stok' => $request->permintaan_stok
                ]);


            return redirect()->back()->with('success', 'Permintaan Restok Barang Berhasil Diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Permintaan Restok Barang Gagal Diubah');
        }
    }

    public function terima(Request $request)
    {
        try {
            Restok::where('id', $request->id)
                ->update([
                    'terpenuhi_stok' => $request->terpenuhi_stok
                ]);

            //jumlahkan barang yg sudah ada
            Barang::where('id', $request->id_barang)
                ->increment('stok', $request->terpenuhi_stok);

            return redirect()->back()->with('success', 'Permintaan Restok Barang Berhasil Diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Permintaan Restok Barang Gagal Diubah');
        }
    }

    public function hapus(Request $request)
    {

        $query = Restok::where('id', $request->id)->delete();

        if ($query) {
            return redirect()->back()->with('success', 'Permintaan Restok Barang Berhasil Dihapus');
        } else {
            return redirect()->back()->with('alert', 'Permintaan Restok Barang Gagal Dihapus');
        }
    }
}
