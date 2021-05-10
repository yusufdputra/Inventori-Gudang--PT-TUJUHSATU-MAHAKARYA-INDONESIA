<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'kategoris';
    protected $dates = ['deleted_at'];

    public function barang()
    {
        return $this->belongsToMany(Barang::class);
    }
}
