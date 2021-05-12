<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Kelola Data Barang";

        $barang = Barang::orderBy('created_at', 'DESC')->get();
        return view('admin.barang.index', compact('title', 'barang'));
    }

    public function store(Request $request)
    {
        try {
            $query = Barang::insert([
                'nama' => $request->nama,
                'satuan' => $request->satuan,
                'stok' => $request->stok,
                'created_at' => Carbon::now(),

            ]);
            if ($query) {
                return redirect()->back()->with('success', 'Barang berhasil ditambah');
            } else {
                return redirect()->back()->with('alert', 'Barang gagal ditambah');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Barang gagal ditambah');
        }
    }

    public function edit($id)
    {
        return Barang::find($id);
    }

    public function update(Request $request)
    {
        try {
            Barang::where('id', $request->id)
                ->update([
                    'nama' => $request->nama,
                    'satuan' => $request->satuan,
                    'stok' => $request->stok
                ]);

            return redirect()->back()->with('success', 'Barang berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Barang gagal diubah');
        }
    }

    public function hapus(Request $request)
    {
        $query = Barang::where('id', $request->id)->delete();

        if ($query) {
            return redirect()->back()->with('success', 'Berhasil menghapus Barang');
        } else {
            return redirect()->back()->with('alert', 'Gagal menghapus Barang');
        }
    }

    public function getBarangById($id)
    {
        return Barang::find($id);
    }
}
