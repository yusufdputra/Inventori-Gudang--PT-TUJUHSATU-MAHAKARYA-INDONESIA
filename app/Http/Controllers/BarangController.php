<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
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
        $users = User::with('roles')->get();
        $pegawai = $users->reject(function ($admin, $key) {
            return $admin->hasRole('admin');
        });
        $barang = Barang::select('barangs.*', 'kategoris.nama as nama_kategori', 'kategoris.id as id_ktg')
            ->join('kategoris', 'barangs.id_kategori', '=', 'kategoris.id')
            ->orderBy('barangs.id_kategori', 'ASC')
            ->orderBy('barangs.harga', 'ASC')
            ->get();
        $kategori = Kategori::all();
        return view('admin.barang.index', compact('pegawai', 'title', 'barang', 'kategori'));
    }

    public function store(Request $request)
    {
        $query = Barang::insert([
            'nama'=> $request->nama,
            'suplier' => $request->suplier,
            'harga' => $request->harga,
            'id_kategori' => $request->kategori,

        ]);
        if ($query) {
            return redirect()->back()->with('success', 'Barang berhasil ditambah');
        }else{
            return redirect()->back()->with('alert', 'Barang gagal ditambah');
        }
    }

    public function edit($id)
    {
        return Barang::find($id);
    }

    public function update(Request $request)
    {
        Barang::where('id', $request->id)
        ->update([
            'nama'=> $request->nama,
            'suplier' => $request->suplier,
            'harga' => $request->harga,
            'id_kategori' => $request->kategori
        ]);

        return redirect()->back()->with('success', 'Barang berhasil diubah');
    }

    public function hapus(Request $request)
    {
        $query = Barang::where('id', $request->id)->delete();

        if($query){
            return redirect()->back()->with('success', 'Berhasil menghapus Barang');
        }else{
            return redirect()->back()->with('alert', 'Gagal menghapus Barang');
        }
    }
}
