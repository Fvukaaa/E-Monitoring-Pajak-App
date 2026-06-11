<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WajibPajak;
use App\Models\Pengawasan;
use App\Models\StatusPengawasan;
use App\Models\KepatuhanBulanan;

class WajibPajakController extends Controller
{
    public function index(Request $request)
    {
        $selectedTahun = $request->input('tahun', date('Y'));

        $wajibPajaks = WajibPajak::with(['kepatuhanBulanan' => function ($query) use ($selectedTahun) {
            $query->where('tahun', $selectedTahun);
        }])->get();

        $availableYears = KepatuhanBulanan::select('tahun')->distinct()->pluck('tahun')->toArray();
        $currentYear = (int)date('Y');
        
        for ($y = $currentYear; $y >= $currentYear - 10; $y--) {
            if (!in_array((string)$y, $availableYears)) {
                $availableYears[] = (string)$y;
            }
        }

        if (!in_array($selectedTahun, $availableYears)) {
            $availableYears[] = $selectedTahun;
        }

        rsort($availableYears);

        return view('wajib-pajak', compact('wajibPajaks', 'selectedTahun', 'availableYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bulan' => 'required|string',
            'tahun' => 'required|string',
            'status_kepatuhan' => 'required|in:PATUH,TIDAK PATUH'
        ]);

        $wp = WajibPajak::create(['nama' => $request->nama]);

        KepatuhanBulanan::create([
            'wajib_pajak_id' => $wp->id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'status_kepatuhan' => $request->status_kepatuhan
        ]);

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
            'tahun' => 'required|string',
            'status_kepatuhan' => 'required|in:PATUH,TIDAK PATUH'
        ]);

        $wajibPajak = WajibPajak::findOrFail($id);

        $kepatuhan = KepatuhanBulanan::query()->where('wajib_pajak_id', $id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->first();

        if ($kepatuhan) {
            $kepatuhan->update(['status_kepatuhan' => $request->status_kepatuhan]);
        } else {
            KepatuhanBulanan::create([
                'wajib_pajak_id' => $id,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
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
