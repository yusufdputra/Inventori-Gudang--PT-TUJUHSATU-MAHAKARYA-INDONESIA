<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barangs';
    protected $dates = ['deleted_at'];

    public function barangmasuk()
    {
        return $this->belongsToMany(BarangMasuk::class);
    }

    public function barangkeluar()
    {
        return $this->belongsToMany(BarangKeluar::class);
    }
    public function restok()
    {
        return $this->belongsToMany(Restok::class);
    }
    
}
