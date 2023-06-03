<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pemilihan',
        'deskripsi',
        'status',
        'image',
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    public function Kandidat()
    {
        return $this->hasMany(Kandidat::class, 'id_pemilihan');
    }
    public function Vote()
    {
        return $this->hasMany(Vote::class);
    }
}
