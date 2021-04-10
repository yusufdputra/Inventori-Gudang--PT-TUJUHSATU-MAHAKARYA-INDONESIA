<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $table = 'agenda_harians';
    protected $fillable = [
        'id',
        'nomor_surat',
        'tanggal',
        'jam',
        'tempat',
        'jenis_agenda',
        'tujuan_jenis',
        'tujuan_bidang',
        'tujuan_orang',
        'keterangan',
        'file_upload',
        'status'
    ];

    public function users()
    {
        return $this->hasOne(User::class,'id', 'tujuan_orang');
    }
    public function bidang()
    {
        return $this->hasOne(Bidang::class, 'id', 'tujuan_bidang');
    }
}
