<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WajibPajak;
use App\Models\Pengawasan;
use Illuminate\Support\Facades\Storage;

class PengawasanController extends Controller
{
    public function index()
    {
        $wajibPajaks = WajibPajak::with('pengawasan')->get();
        return view('pengawasan', compact('wajibPajaks'));
    }

    public function update(Request $request, string $id)
    {
        $pengawasan = Pengawasan::findOrFail($id);

        $data = $request->except(['file_surat_tugas', 'file_bap', 'file_laporan']);

        if ($request->hasFile('file_surat_tugas')) {
            $data['file_surat_tugas'] = $request->file('file_surat_tugas')->store('dokumen_pengawasan', 'public');
        }
        if ($request->hasFile('file_bap')) {
            $data['file_bap'] = $request->file('file_bap')->store('dokumen_pengawasan', 'public');
        }
        if ($request->hasFile('file_laporan')) {
            $data['file_laporan'] = $request->file('file_laporan')->store('dokumen_pengawasan', 'public');
        }

        $pengawasan->update($data);

        return redirect()->route('pengawasan.index')->with('success', 'Data pengawasan berhasil disimpan');
    }
}
