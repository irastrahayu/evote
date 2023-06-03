<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'user_id',
        'kandidat_id',
        'pemilihan_id'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Pemilihan()
    {
        return $this->belongsTo(User::class);
    }

    public function Kandidat()
    {
        return $this->belongsTo(Kandidat::class);
    }
}
