<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WajibPajak;
use App\Models\StatusPengawasan;

class StatusPengawasanController extends Controller
{
    public function index()
    {
        $wajibPajaks = WajibPajak::with('statusPengawasan')->get();
        return view('status-pengawasan', compact('wajibPajaks'));
    }

    public function update(Request $request, string $id)
    {
        $status = StatusPengawasan::findOrFail($id);
        
        $data = $request->except(['file_dokumen']);

        if ($request->hasFile('file_dokumen')) {
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_status', 'public');
        }

        $status->update($data);

        return redirect()->route('status-pengawasan.index')->with('success', 'Status pengawasan berhasil disimpan');
    }
}
