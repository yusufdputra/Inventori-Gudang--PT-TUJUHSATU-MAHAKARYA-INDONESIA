<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class CetakController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function cetak(Request $request)
    {
        $date = str_replace('/', '-', $request->start_date);
        $start = date('Y-m-d', strtotime($date));
        $date2 = str_replace('/', '-', $request->end_date);
        $end = date('Y-m-d h:m:s', strtotime($date2));


        if ($request->jenis == 'keluar') {
            $barang = BarangKeluar::with('barang')->whereBetween('created_at',[$start, $end])->orderBy('created_at', 'DESC')->get();
            $pdf = PDF::loadview('cetak.keluar', compact('barang', 'start', 'end'));
        }else{
            $barang = BarangMasuk::with('barang')->whereBetween('created_at',[$start, $end])->orderBy('created_at', 'DESC')->get();
            $pdf = PDF::loadview('cetak.masuk', compact('barang', 'start', 'end'));

        }
        

        return $pdf->stream();
    }
}
