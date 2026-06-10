@extends('layouts.app')

@section('title', 'Status Pengawasan Pajak Air Tanah')

@section('content')
    <div class="content-header">
        <h1>STATUS PENGAWASAN PAJAK AIR TANAH</h1>
    </div>

    <div class="content-body">
        @if (session('success'))
            <div style="margin: 0 0 20px; padding: 10px; background-color: #d1fae5; color: #065f46; border-radius: 5px;">
                {{ session('success') }}
            </div>
        @endif
        <div class="page-section" style="overflow-x: auto;">
            <table class="data-table table-detail">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th class="col-wajib">WAJIB PAJAK AIR TANAH</th>
                        <th class="col-permasalahan">PERMASALAHAN / TEMUAN</th>
                        <th class="col-tindaklanjut">TINDAKLANJUT</th>
                        <th class="col-hasil">HASIL</th>
                        <th class="col-status">STATUS</th>
                        <th class="col-dokumen">UPLOAD DOKUMEN HASIL TINDAKLANJUT</th>
                        <th style="text-align: center; width: 10%">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wajibPajaks as $wp)
                        @if ($wp->statusPengawasan)
                            <tr>
                                <td style="text-align: center; width: 4%;">{{ $loop->iteration }}.</td>
                                <td style="text-align: left; font-weight: bold;">{{ $wp->nama }}</td>
                                <td>
                                    <span
                                        class="text-content">{{ $wp->statusPengawasan->permasalahan ?: 'Belum diisi' }}</span>
                                </td>
                                <td>
                                    <span
                                        class="text-content">{{ $wp->statusPengawasan->tindak_lanjut ?: 'Belum diisi' }}</span>
                                </td>
                                <td>
                                    <span class="text-content">{{ $wp->statusPengawasan->hasil ?: 'Belum diisi' }}</span>
                                </td>
                                <td>
                                    @if ($wp->statusPengawasan->status == 'SELESAI')
                                        <span class="status-label selesai">SELESAI</span>
                                    @else
                                        <span class="status-label belum">BELUM</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($wp->statusPengawasan->file_dokumen)
                                        <a href="{{ asset('storage/' . $wp->statusPengawasan->file_dokumen) }}"
                                            target="_blank" style="font-size:12px;color:#2563eb;">[Lihat Dokumen]</a>
                                    @else
                                        <span style="font-size:12px;color:#9ca3af;">Belum ada dokumen</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <button
                                        onclick="document.getElementById('editModal-{{ $wp->statusPengawasan->id }}').style.display='flex'"
                                        class="btn btn-save" title="Edit Status"
                                        style="padding: 6px 10px; font-size: 16px; margin: 0; display: inline-flex; align-items: center; justify-content: center;"><i
                                            class="ph-fill ph-pencil-simple"></i></button>
                                </td>
                            </tr>

                            <!-- Modal Edit Status Pengawasan -->
                            <div id="editModal-{{ $wp->statusPengawasan->id }}"
                                style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">
                                <div style="background:#fff; padding:20px; border-radius:8px; width:500px; max-width:90%;">
                                    <h3 style="margin-top:0;">Edit Status Pengawasan - {{ $wp->nama }}</h3>
                                    <form action="{{ route('status-pengawasan.update', $wp->statusPengawasan->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div style="margin-bottom:15px;">
                                            <label style="display:block; margin-bottom:5px;">Permasalahan / Temuan</label>
                                            <textarea name="permasalahan" class="form-input" style="width:100%; min-height:60px; box-sizing:border-box;">{{ $wp->statusPengawasan->permasalahan }}</textarea>
                                        </div>
                                        <div style="margin-bottom:15px;">
                                            <label style="display:block; margin-bottom:5px;">Tindaklanjut</label>
                                            <textarea name="tindak_lanjut" class="form-input" style="width:100%; min-height:60px; box-sizing:border-box;">{{ $wp->statusPengawasan->tindak_lanjut }}</textarea>
                                        </div>
                                        <div style="margin-bottom:15px;">
                                            <label style="display:block; margin-bottom:5px;">Hasil</label>
                                            <textarea name="hasil" class="form-input" style="width:100%; min-height:60px; box-sizing:border-box;">{{ $wp->statusPengawasan->hasil }}</textarea>
                                        </div>
                                        <div style="margin-bottom:15px;">
                                            <label style="display:block; margin-bottom:5px;">Status</label>
                                            <select name="status" class="form-input"
                                                style="width:100%; box-sizing:border-box;">
                                                <option value="BELUM"
                                                    {{ $wp->statusPengawasan->status == 'BELUM' ? 'selected' : '' }}>BELUM
                                                </option>
                                                <option value="SELESAI"
                                                    {{ $wp->statusPengawasan->status == 'SELESAI' ? 'selected' : '' }}>
                                                    SELESAI</option>
                                            </select>
                                        </div>
                                        <div style="margin-bottom:15px;">
                                            <label style="display:block; margin-bottom:5px;">Upload Dokumen Hasil
                                                Tindaklanjut</label>
                                            <input type="file" name="file_dokumen" class="form-input-file"
                                                style="width:100%; box-sizing:border-box;">
                                        </div>
                                        <div style="text-align:right;">
                                            <button type="button" class="btn btn-reset"
                                                onclick="document.getElementById('editModal-{{ $wp->statusPengawasan->id }}').style.display='none'">Batal</button>
                                            <button type="submit" class="btn btn-save">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
