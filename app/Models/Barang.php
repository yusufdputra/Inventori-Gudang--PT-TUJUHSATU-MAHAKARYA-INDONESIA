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

    public function rabtemp()
    {
        return $this->belongsToMany(RabTemp::class);
    }
    public function kategori()
    {
        return $this->hasMany(Kategori::class, 'id', 'id_kategori');
    }
}
