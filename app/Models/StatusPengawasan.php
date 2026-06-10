<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPengawasan extends Model
{
    protected $fillable = ['wajib_pajak_id', 'permasalahan', 'tindak_lanjut', 'hasil', 'status', 'file_dokumen'];

    public function wajibPajak()
    {
        return $this->belongsTo(WajibPajak::class);
    }
}
