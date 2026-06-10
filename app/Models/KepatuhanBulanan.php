<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepatuhanBulanan extends Model
{
    protected $fillable = ['wajib_pajak_id', 'bulan', 'status_kepatuhan'];

    public function wajibPajak()
    {
        return $this->belongsTo(WajibPajak::class);
    }
}
