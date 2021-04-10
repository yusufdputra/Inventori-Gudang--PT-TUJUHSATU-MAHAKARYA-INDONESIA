<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Bidang extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 
        'name',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function agenda()
    {
        return $this->hasOne(Agenda::class, 'id', 'tujuang_bidang');
    }
}
