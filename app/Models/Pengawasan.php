<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengawasan extends Model
{
    protected $fillable = ['wajib_pajak_id', 'tanggal', 'file_surat_tugas', 'file_bap', 'file_laporan'];

    public function wajibPajak()
    {
        return $this->belongsTo(WajibPajak::class);
    }
}
