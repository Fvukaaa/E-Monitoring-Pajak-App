@extends('layouts.app')

@section('title', 'Pengawasan Pajak Air Tanah')

@section('content')
    <div class="content-header">
        <h1>PENGAWASAN PAJAK AIR TANAH</h1>
    </div>

    <div class="content-body">
        @if (session('success'))
            <div style="margin: 0 0 20px; padding: 10px; background-color: #d1fae5; color: #065f46; border-radius: 5px;">
                {{ session('success') }}
            </div>
        @endif
        <div class="page-section" style="overflow-x: auto;">
            <table class="data-table table-upload">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th class="col-wajib">WAJIB PAJAK AIR TANAH</th>
                        <th style="text-align: left;">TANGGAL PENGAWASAN</th>
                        <th style="text-align: left;">UPLOAD SURAT TUGAS</th>
                        <th style="text-align: left;">UPLOAD BERITA ACARA TUGAS PENGAWASAN</th>
                        <th style="text-align: left;">UPLOAD LAPORAN PENGAWASAN</th>
                        <th style="text-align: center; width: 10%;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wajibPajaks as $wp)
                        @if ($wp->pengawasan)
                            <tr>
                                <td style="text-align: center;">{{ $loop->iteration }}.</td>
                                <td style="text-align: left; font-weight: bold;">{{ $wp->nama }}</td>
                                <td>
                                    {{ $wp->pengawasan->tanggal ? $wp->pengawasan->tanggal : 'Belum ada data' }}
                                </td>
                                <td>
                                    @if ($wp->pengawasan->file_surat_tugas)
                                        <a href="{{ asset('storage/' . $wp->pengawasan->file_surat_tugas) }}"
                                            target="_blank" style="font-size:12px;color:#2563eb;">[Lihat File Surat
                                            Tugas]</a>
                                    @else
                                        <span style="font-size:12px;color:#9ca3af;">Belum ada data yang di upload</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($wp->pengawasan->file_bap)
                                        <a href="{{ asset('storage/' . $wp->pengawasan->file_bap) }}" target="_blank"
                                            style="font-size:12px;color:#2563eb;">[Lihat File BAP]</a>
                                    @else
                                        <span style="font-size:12px;color:#9ca3af;">Belum ada data yang di upload</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($wp->pengawasan->file_laporan)
                                        <a href="{{ asset('storage/' . $wp->pengawasan->file_laporan) }}" target="_blank"
                                            style="font-size:12px;color:#2563eb;">[Lihat File Laporan]</a>
                                    @else
                                        <span style="font-size:12px;color:#9ca3af;">Belum ada data yang di upload</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <button
                                        onclick="document.getElementById('editModal-{{ $wp->pengawasan->id }}').style.display='flex'"
                                        class="btn btn-save" title="Edit / Upload"
                                        style="padding: 6px 10px; font-size: 16px; margin: 0; display: inline-flex; align-items: center; justify-content: center;"><i
                                            class="ph-fill ph-pencil-simple"></i></button>
                                </td>
                            </tr>

                            <!-- Modal Edit/Upload Pengawasan -->
                            <div id="editModal-{{ $wp->pengawasan->id }}"
                                style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">
                                <div style="background:#fff; padding:20px; border-radius:8px; width:500px; max-width:90%;">
                                    <h3 style="margin-top:0;">Edit Pengawasan - {{ $wp->nama }}</h3>
                                    <form action="{{ route('pengawasan.update', $wp->pengawasan->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div style="margin-bottom:15px;">
                                            <label style="display:block; margin-bottom:5px;">Tanggal Pengawasan</label>
                                            <input type="date" name="tanggal" value="{{ $wp->pengawasan->tanggal }}"
                                                class="form-input" style="width:100%; box-sizing:border-box;">
                                        </div>
                                        <div style="margin-bottom:15px;">
                                            <label style="display:block; margin-bottom:5px;">Upload Surat Tugas</label>
                                            <input type="file" name="file_surat_tugas" class="form-input-file"
                                                style="width:100%;">
                                        </div>
                                        <div style="margin-bottom:15px;">
                                            <label style="display:block; margin-bottom:5px;">Upload Berita Acara</label>
                                            <input type="file" name="file_bap" class="form-input-file"
                                                style="width:100%;">
                                        </div>
                                        <div style="margin-bottom:15px;">
                                            <label style="display:block; margin-bottom:5px;">Upload Laporan</label>
                                            <input type="file" name="file_laporan" class="form-input-file"
                                                style="width:100%;">
                                        </div>
                                        <div style="text-align:right;">
                                            <button type="button" class="btn btn-reset"
                                                onclick="document.getElementById('editModal-{{ $wp->pengawasan->id }}').style.display='none'">Batal</button>
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
