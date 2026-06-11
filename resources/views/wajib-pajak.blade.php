@extends('layouts.app')

@section('title', 'Wajib Pajak Air Tanah')

@section('content')
    <div class="content-header"
        style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <h1>DATA WAJIB PAJAK AIR TANAH</h1>
        <div style="display: flex; align-items: center; gap: 20px;">
            <form action="{{ route('wajib-pajak.index') }}" method="GET"
                style="margin: 0; display: flex; align-items: center; gap: 10px;">
                <label for="tahun" style="font-weight: bold; margin: 0;">Tahun:</label>
                <select name="tahun" id="tahun" class="form-input"
                    style="padding: 5px 10px; border-radius: 5px; border: 1px solid #ccc; height: auto;"
                    onchange="this.form.submit()">
                    @foreach ($availableYears as $year)
                        <option value="{{ $year }}" {{ $selectedTahun == $year ? 'selected' : '' }}>
                            {{ $year }}</option>
                    @endforeach
                </select>
            </form>
            <button onclick="document.getElementById('addModal').style.display='flex'" class="btn btn-save"
                style="margin-right: 20px; display: inline-flex; align-items: center; gap: 5px;">
                <i class="ph-fill ph-plus-circle" style="font-size: 18px;"></i> Tambah Wajib Pajak
            </button>
        </div>
    </div>

    @if (session('success'))
        <div style="margin: 0 20px 20px; padding: 10px; background-color: #d1fae5; color: #065f46; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <style>
        .table-months th,
        .table-months td {
            border: 1px solid #e5e7eb;
        }
    </style>
    <div class="content-body">
        <div class="page-section" style="overflow-x: auto;">
            <table class="data-table table-months">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 4%;">No.</th>
                        <th class="col-wajib" style="min-width: 200px;">WAJIB PAJAK</th>
                        @php $months = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGUS', 'SEP', 'OKT', 'NOV', 'DES']; @endphp
                        @foreach ($months as $m)
                            <th>{{ $m }}</th>
                        @endforeach
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wajibPajaks as $wp)
                        <tr>
                            <td style="text-align: center; width: 2%;">{{ $loop->iteration }}.</td>

                            <td style="text-align: left; font-weight: bold;">{{ $wp->nama }}</td>
                            @foreach ($months as $m)
                                @php
                                    $kepatuhan = $wp->kepatuhanBulanan->where('bulan', $m)->first();
                                @endphp
                                <td style="text-align: center; font-size: 11px;">
                                    @if ($kepatuhan)
                                        @if ($kepatuhan->status_kepatuhan == 'PATUH')
                                            <span
                                                style="background-color: #d1fae5; color: #065f46; padding: 3px 6px; border-radius: 4px; display: inline-block; white-space: nowrap; font-weight: 500;">PATUH</span>
                                        @else
                                            <span
                                                style="background-color: #fee2e2; color: #991b1b; padding: 3px 6px; border-radius: 4px; display: inline-block; white-space: nowrap; font-weight: 500;">TIDAK
                                                PATUH</span>
                                        @endif
                                    @endif
                                </td>
                            @endforeach
                            <td style="text-align: center; min-width: 120px;">
                                <button
                                    onclick="document.getElementById('editModal-{{ $wp->id }}').style.display='flex'"
                                    class="btn btn-save" title="Input Bulan"
                                    style="padding: 6px 10px; font-size: 16px; margin: 0 5px 0 0; display: inline-flex; align-items: center; justify-content: center;"><i
                                        class="ph-fill ph-pencil-simple"></i></button>
                                <form action="{{ route('wajib-pajak.destroy', $wp->id) }}" method="POST"
                                    style="display:inline;" onsubmit="return confirm('Hapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-reset" title="Hapus"
                                        style="padding: 6px 10px; font-size: 16px; margin: 0; display: inline-flex; align-items: center; justify-content: center;"><i
                                            class="ph-fill ph-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Wajib Pajak -->
                        <div id="editModal-{{ $wp->id }}"
                            style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">
                            <div style="background:#fff; padding:20px; border-radius:8px; width:400px; max-width:90%;">
                                <h3 style="margin-top:0;">Input Status Bulan - {{ $wp->nama }}</h3>
                                <form action="{{ route('wajib-pajak.store-bulan', $wp->id) }}" method="POST">
                                    @csrf
                                    <div style="margin-bottom:15px; display: flex; gap: 10px;">
                                        <div style="flex: 1;">
                                            <label style="display:block; margin-bottom:5px;">Pilih Bulan</label>
                                            <select name="bulan" class="form-input"
                                                style="width:100%; box-sizing:border-box; height:38px;">
                                                @foreach ($months as $m)
                                                    <option value="{{ $m }}">{{ $m }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div style="flex: 1;">
                                            <label style="display:block; margin-bottom:5px;">Tahun</label>
                                            <select name="tahun" class="form-input"
                                                style="width:100%; box-sizing:border-box; height:38px;">
                                                @foreach ($availableYears as $year)
                                                    <option value="{{ $year }}"
                                                        {{ $selectedTahun == $year ? 'selected' : '' }}>
                                                        {{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div style="margin-bottom:15px;">
                                        <label style="display:block; margin-bottom:5px;">Status Kepatuhan</label>
                                        <select name="status_kepatuhan" class="form-input"
                                            style="width:100%; box-sizing:border-box; height:38px;">
                                            <option value="PATUH">PATUH</option>
                                            <option value="TIDAK PATUH">TIDAK PATUH</option>
                                        </select>
                                    </div>
                                    <div style="text-align:right;">
                                        <button type="button" class="btn btn-reset"
                                            onclick="document.getElementById('editModal-{{ $wp->id }}').style.display='none'">Batal</button>
                                        <button type="submit" class="btn btn-save">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Wajib Pajak -->
    <div id="addModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">
        <div style="background:#fff; padding:20px; border-radius:8px; width:400px; max-width:90%;">
            <h3 style="margin-top:0;">Tambah Wajib Pajak</h3>
            <form action="{{ route('wajib-pajak.store') }}" method="POST">
                @csrf
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px;">Nama Perusahaan / Wajib Pajak</label>
                    <input type="text" name="nama" class="form-input" style="width:100%; box-sizing:border-box;"
                        required>
                </div>
                <div style="margin-bottom:15px; display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label style="display:block; margin-bottom:5px;">Pilih Bulan</label>
                        <select name="bulan" class="form-input" style="width:100%; box-sizing:border-box; height:38px;">
                            @php $months = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGUS', 'SEP', 'OKT', 'NOV', 'DES']; @endphp
                            @foreach ($months as $m)
                                <option value="{{ $m }}">{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label style="display:block; margin-bottom:5px;">Tahun</label>
                        <select name="tahun" class="form-input"
                            style="width:100%; box-sizing:border-box; height:38px;">
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}" {{ $selectedTahun == $year ? 'selected' : '' }}>
                                    {{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px;">Status Kepatuhan</label>
                    <select name="status_kepatuhan" class="form-input"
                        style="width:100%; box-sizing:border-box; height:38px;">
                        <option value="PATUH">PATUH</option>
                        <option value="TIDAK PATUH">TIDAK PATUH</option>
                    </select>
                </div>
                <div style="text-align:right;">
                    <button type="button" class="btn btn-reset"
                        onclick="document.getElementById('addModal').style.display='none'">Batal</button>
                    <button type="submit" class="btn btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
