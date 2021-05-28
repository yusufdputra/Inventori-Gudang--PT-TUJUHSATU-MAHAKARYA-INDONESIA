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

    public function kategori()
    {
        return $this->hasMany(Kategori::class, 'id', 'id_kategori')->withTrashed();
    }

    public function peminjaman()
    {
        return $this->belongsToMany(Peminjaman::class);
    }

    public function restok()
    {
        return $this->belongsToMany(Restok::class);
    }
    
}
