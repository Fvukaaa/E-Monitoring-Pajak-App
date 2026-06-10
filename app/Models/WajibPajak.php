<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WajibPajak extends Model
{
    protected $fillable = ['nama'];

    public function kepatuhanBulanan()
    {
        return $this->hasMany(KepatuhanBulanan::class);
    }

    public function pengawasan()
    {
        return $this->hasOne(Pengawasan::class);
    }

    public function statusPengawasan()
    {
        return $this->hasOne(StatusPengawasan::class);
    }
}
