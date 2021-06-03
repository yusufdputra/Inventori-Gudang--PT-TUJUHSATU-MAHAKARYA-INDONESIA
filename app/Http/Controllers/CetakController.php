<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Peminjaman;
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
        $end = date('Y-m-d', strtotime($date2));

        
        if ($request->jenis == 'pinjam') {
            $header = "LAPORAN PEMINJAMAN BARANG";
            $barang = Peminjaman::with('barang')
            ->whereNull('pengembalian_at')
            ->whereBetween('created_at',[$start, $end])
            ->orderBy('created_at', 'DESC')
            ->get();
        }else{
            $header = "LAPORAN PENGEMBALIAN BARANG";
            $barang = Peminjaman::with('barang')
            ->whereNotNull('pengembalian_at')
            ->whereBetween('created_at',[$start, $end])
            ->orderBy('created_at', 'DESC')
            ->get();
        }
        $pdf = PDF::loadview('cetak.index', compact('barang', 'start', 'end', 'header'))->setPaper('a4', 'landscape');
        

        return $pdf->stream();
    }
}
