<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Rab;
use App\Models\RabTemp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RabTempController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $title = "Tambah Rancangan Anggaran Biaya (RAB)";
        $users = User::with('roles')->get();
        $pegawai = $users->reject(function ($admin, $key) {
            return $admin->hasRole('admin');
        });
        $rab = RabTemp::with('barang')->where('is_selesai', 0)->get();
        $kategori = Kategori::orderBy('nama')->get();

        return view('admin.rabtemp.index', compact('pegawai', 'title', 'rab', 'kategori'));
    }

    public function store(Request $request)
    {
        $query = RabTemp::insert([
            'id_barang' => $request->id_barang,
            'kuantitas' => $request->kuantitas,
            'created_at' => Carbon::now('+7:00')

        ]);
        if ($query) {
            return redirect()->back()->with('success', 'RAB berhasil ditambah');
        } else {
            return redirect()->back()->with('alert', 'RAB gagal ditambah');
        }
    }

    public function edit($id)
    {
        $barang = RabTemp::find($id)->barang;
        $rabTemp = RabTemp::find($id);
        $barangs = Barang::where('id_kategori', $barang[0]['id_kategori'])->get();
        $data = compact('barang', 'rabTemp', 'barangs');
        return ($data);
    }

    public function update(Request $request)
    {
        RabTemp::where('id', $request->id)
            ->update([
                'id_barang' => $request->id_barang,
                'kuantitas' => $request->kuantitas,
            ]);

        return redirect()->back()->with('success', 'RAB berhasil diubah');
    }

    public function hapus(Request $request)
    {
        $query = RabTemp::where('id', $request->id)->delete();

        if ($query) {
            return redirect()->back()->with('success', 'Berhasil menghapus Barang');
        } else {
            return redirect()->back()->with('alert', 'Gagal menghapus Barang');
        }
    }

    public function selesai(Request $request)
    {
        $rab_temps = RabTemp::where('is_selesai', 0)->get();
        $arr_id_temps = array();
        foreach ($rab_temps as $key => $value) {
            $arr_id_temps[$key] = $value->id;
        }
        try {
            $simpan = Rab::insert([
                'nama' => $request->nama,
                // 'harga_total' => $request->harga_total,   
                'id_rab_temp' => serialize($arr_id_temps)
            ]);

            if ($simpan) {
                // ubah status di temps
                foreach ($arr_id_temps as $key => $value) {
                    RabTemp::where('id', $value)->update([
                        'is_selesai' => 1
                    ]);
                }
                return redirect()->route('rab.index')->with('success', 'RAB ' . $request->nama . ' berhasil ditambah');
            } else {
                return redirect()->back()->with('alert', 'RAB gagal ditambah');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'RAB gagal ditambah');
        }
    }
}
