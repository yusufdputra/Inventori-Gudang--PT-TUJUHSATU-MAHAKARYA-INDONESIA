<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Request as ModelsRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $title = "Permintaan Request Barang";
        $barang = Barang::all();
        $request = ModelsRequest::with('barang')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('request.index', compact('request', 'title', 'barang'));
    }

    public function store(Request $request)
    {
        try {
            $cek = ModelsRequest::where('id_barang', $request->id)->whereNull('terpenuhi');
            if (!$cek->exists()) {
                $query = ModelsRequest::insert([
                    'id_barang' => $request->id,
                    'stok' => $request->permintaan_stok,
                    'created_at' => Carbon::now(),
                ]);
                if ($query) {
                    return redirect()->back()->with('success', 'Permintaan Request Barang Berhasil Diajukan. Lihat Menu Request Stok');
                } else {
                    return redirect()->back()->with('alert', 'Permintaan Request Barang Gagal Diajukan');
                }
            } else {
                return redirect()->back()->with('alert', 'Permintaan Dengan ID Barang Sudah Diajukan. Lihat Menu Request Stok');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Permintaan Request Barang Gagal Diajukan');
        }
    }

    public function edit($id)
    {
        return ModelsRequest::with('barang')->where('id', $id)->first();
    }

    public function update(Request $request)
    {
        try {
            ModelsRequest::where('id', $request->id)
                ->update([
                    'id_barang' => $request->id_barang,
                    'stok' => $request->permintaan_stok
                ]);


            return redirect()->back()->with('success', 'Permintaan Request Barang Berhasil Diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Permintaan Request Barang Gagal Diubah');
        }
    }

    public function terima(Request $request)
    {
        try {
            ModelsRequest::where('id', $request->id)
                ->update([
                    'terpenuhi' => $request->terpenuhi_stok
                ]);

            //jumlahkan barang yg sudah ada
            Barang::where('id', $request->id_barang)
                ->increment('stok', $request->terpenuhi_stok);

            return redirect()->back()->with('success', 'Permintaan Request Barang Berhasil Diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Permintaan Request Barang Gagal Diubah');
        }
    }

    public function hapus(Request $request)
    {

        $query = ModelsRequest::where('id', $request->id)->delete();

        if ($query) {
            return redirect()->back()->with('success', 'Permintaan Request Barang Berhasil Dihapus');
        } else {
            return redirect()->back()->with('alert', 'Permintaan Request Barang Gagal Dihapus');
        }
    }
}
