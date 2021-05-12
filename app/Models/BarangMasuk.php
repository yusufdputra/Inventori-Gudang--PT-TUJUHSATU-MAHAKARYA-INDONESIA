<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangMasuk extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'barang_masuks';
    protected $dates = ['deleted_at'];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id', 'id_barang');
    }
}
