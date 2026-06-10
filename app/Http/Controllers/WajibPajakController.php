<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WajibPajak;
use App\Models\Pengawasan;
use App\Models\StatusPengawasan;
use App\Models\KepatuhanBulanan;

class WajibPajakController extends Controller
{
    public function index()
    {
        $wajibPajaks = WajibPajak::with('kepatuhanBulanan')->get();
        return view('wajib-pajak', compact('wajibPajaks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bulan' => 'required|string',
            'status_kepatuhan' => 'required|in:PATUH,TIDAK PATUH'
        ]);

        $wp = WajibPajak::create(['nama' => $request->nama]);

        // Add kepatuhan bulanan
        KepatuhanBulanan::create([
            'wajib_pajak_id' => $wp->id,
            'bulan' => $request->bulan,
            'status_kepatuhan' => $request->status_kepatuhan
        ]);

        // Automatically create relations
        Pengawasan::create(['wajib_pajak_id' => $wp->id]);
        StatusPengawasan::create(['wajib_pajak_id' => $wp->id]);

        return redirect()->route('wajib-pajak.index')->with('success', 'Wajib Pajak berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $wajibPajak = WajibPajak::findOrFail($id);
        $wajibPajak->update(['nama' => $request->nama]);

        return redirect()->route('wajib-pajak.index')->with('success', 'Nama berhasil diubah');
    }

    public function storeBulan(Request $request, string $id)
    {
        $request->validate([
            'bulan' => 'required|string',
            'status_kepatuhan' => 'required|in:PATUH,TIDAK PATUH'
        ]);

        $wajibPajak = WajibPajak::findOrFail($id);

        $kepatuhan = KepatuhanBulanan::query()->where('wajib_pajak_id', $id)
            ->where('bulan', $request->bulan)
            ->first();

        if ($kepatuhan) {
            $kepatuhan->update(['status_kepatuhan' => $request->status_kepatuhan]);
        } else {
            KepatuhanBulanan::create([
                'wajib_pajak_id' => $id,
                'bulan' => $request->bulan,
                'status_kepatuhan' => $request->status_kepatuhan
            ]);
        }

        return redirect()->route('wajib-pajak.index')->with('success', 'Data kepatuhan bulan berhasil disimpan');
    }

    public function destroy(string $id)
    {
        WajibPajak::findOrFail($id)->delete();
        return redirect()->route('wajib-pajak.index')->with('success', 'Data berhasil dihapus');
    }
}
