<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Rab;
use App\Models\RabTemp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
class RabController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $title = "Kelola Rancangan Anggaran Biaya (RAB)";
        $users = User::with('roles')->get();
        $pegawai = $users->reject(function ($admin, $key) {
            return $admin->hasRole('admin');
        });
        $rab = Rab::all();
        // hitung total harga
        $harga_total = array();
        foreach ($rab as $key => $value) {
            $harga_total_rab = 0;
            $id_rab_temps = unserialize($value['id_rab_temp']);
            foreach ($id_rab_temps as $k => $id_temp) {
                $rabTemp = RabTemp::with('barang')->where('id', $id_temp)->first();
                $harga_total_rab = $harga_total_rab +( $rabTemp->barang[0]['harga'] * $rabTemp['kuantitas']);
            }
            $harga_total[$key] = $harga_total_rab;
        }

        return view('admin.rab.index', compact('pegawai', 'title', 'rab', 'harga_total'));
    }

    
    public function hapus(Request $request)
    {
        $query = Rab::where('id', $request->id)->delete();

        if ($query) {
            return redirect()->back()->with('success', 'Berhasil menghapus RAB');
        } else {
            return redirect()->back()->with('alert', 'Gagal menghapus RAB');
        }
    }

    public function edit($id_rab_get)
    {
        // get data rab
        $id_rab = Rab::find($id_rab_get);
        $nama_rab =  $id_rab->nama;
        $title = "Ubah Rancangan Anggaran Biaya (RAB) " . $nama_rab;
        // get data array 
        $id_rab_temps = unserialize($id_rab->id_rab_temp);
        // cari data rab temp dari data array
        $rab = array();
        foreach ($id_rab_temps as $key => $value) {
            // get data
            $rab[$key] = RabTemp::with('barang')->where('id', $value)->get();
        }

        // get data kategori
        $kategori = Kategori::orderBy('nama')->get();

        return view('admin.rab.edit', compact('title', 'rab', 'kategori', 'id_rab_get', 'nama_rab'));
    }

    public function editHapus(Request $request)
    {
        try {
            // get data tabel rab by id
            $rab = Rab::where('id', $request->id_rab)->first();
            //get array id rab temp
            $id_rab_temps = unserialize($rab['id_rab_temp']);
            //cari di array berdasarkan value
            // kemudian hapus
            $key = array_search($request->id, $id_rab_temps);
            if ($key !== false) {
                // hapus
                unset($id_rab_temps[$key]);
            }
            // update array id rab temp di tabel rab
            Rab::where('id', $request->id_rab)
                ->update([
                    'id_rab_temp' => serialize($id_rab_temps)
                ]);
            // hapus di tabel rab temp
            $query = RabTemp::where('id', $request->id)->delete();
            if ($query) {
                return redirect()->back()->with('success', 'Berhasil menghapus Barang');
            } else {
                return redirect()->back()->with('alert', 'Gagal menghapus Barang');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Gagal menghapus Barang');
        }
    }

    public function editUpdate(Request $request)
    {
        // update di tabel rab temporary
        RabTemp::where('id', $request->id)
            ->update([
                'id_barang' => $request->id_barang,
                'kuantitas' => $request->kuantitas,
            ]);

        return redirect()->back()->with('success', 'RAB berhasil diubah');
    }

    public function editStore(Request $request)
    {
        try {
            // simpan ke rab temp
            // status auto 1
            $rabTemp = new RabTemp;
            $rabTemp->id_barang = $request->id_barang;
            $rabTemp->kuantitas = $request->kuantitas;
            $rabTemp->is_selesai = 1;
            $rabTemp->created_at = Carbon::now('+7:00');
            $rabTemp->save();

            // get id nya
            $id_temp = $rabTemp->id;
            // tambah ke array tabel rab
            // get data tabel rab by id
            $rab = Rab::where('id', $request->id_rab)->first();
            //get array id rab temp
            $id_rab_temps = unserialize($rab['id_rab_temp']);
            // tambah id temp kedalam array
            array_push($id_rab_temps, $id_temp);
            // update array id rab temp di tabel rab
            $query = Rab::where('id', $request->id_rab)
                ->update([
                    'id_rab_temp' => serialize($id_rab_temps)
                ]);

            if ($query) {
                return redirect()->back()->with('success', 'RAB berhasil ditambah');
            } else {
                return redirect()->back()->with('alert', 'RAB gagal ditambah');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'RAB gagal ditambah ');
        }
    }


    public function editSelesai(Request $request)
    {
        // update di tabel rab temporary
        $query = Rab::where('id', $request->id_rab)
            ->update([
                'nama' => $request->nama
            ]);
        if ($query) {
            return redirect()->route('rab.index')->with('success', 'RAB berhasil diubah');
        } else {
            return redirect()->back()->with('alert', 'RAB berhasil diubah ');
        }
    }

    public function cetak($id_rab)
    {
        $rab = Rab::find($id_rab);
       
        $rab_temp = array();
        foreach (unserialize($rab['id_rab_temp']) as $key => $value) {
            // get data
            $rab_temp[$key] = RabTemp::with('barang')->where('id', $value)->get();
        }

        $pdf = PDF::loadview('admin.rab.cetak', compact('rab_temp', 'rab'));
        return $pdf->stream();
    }
}
