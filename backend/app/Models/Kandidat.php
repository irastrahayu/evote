<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'nama_ketua',
        'id_kelas_ketua',
        'nama_wakil',
        'id_kelas_wakil',
        'visi',
        'misi',
        'id_pemilihan'
    ];

    public function Pemilihan()
    {
        return $this->belongsTo(Pemilihan::class, 'id_pemilihan');
    }

    public function Vote()
    {
        return $this->hasMany(Vote::class);
    }

    public function User()
    {
        return $this->hasMany(User::class);
    }

    // get class data with id_kelas_ketua and id_kelas_wakil
    public function KelasKetua()
    {
        return $this->belongsTo(Kelas::class, 'id');
    }

    public function KelasWakil()
    {
        return $this->belongsTo(Kelas::class, 'id');
    }
}