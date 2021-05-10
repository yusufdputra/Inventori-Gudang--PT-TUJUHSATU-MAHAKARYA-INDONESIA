<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\RabTemp;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function GetBarangByKategori($id_kategori)
    {
        return Barang::where('id_kategori', $id_kategori)
        ->orderBy('harga', 'ASC')
        ->get();
    }
   
}
