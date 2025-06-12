@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('main-content')
<div class="container">
    <h1 class="mb-4">Validasi Dokumen</h1>

    {{-- Tampilkan notifikasi sukses jika ada --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($dokumen)
        <div class="card">
            <div class="card-header">
                <strong>{{ $dokumen->judul }}</strong>
            </div>
            <div class="card-body">
                {{-- Informasi Dokumen --}}
                <div class="mb-2"><strong>Dokumen</strong> : {{ $dokumen->judul }}</div>
                <div class="mb-2"><strong>Kriteria</strong> : {{ $dokumen->kriteria->nama ?? '-' }}</div>
                <div class="mb-2"><strong>Deskripsi</strong> : {{ $dokumen->deskripsi ?? '-' }}</div>
                <div class="mb-2"><strong>Tanggal Upload</strong> : {{ $dokumen->created_at->format('d M Y H:i') }}</div>

                {{-- Tampilkan file/link --}}
                <div class="mb-2">
                    <strong>File</strong> :
                    @php
                        $isUrl = filter_var($dokumen->file_path, FILTER_VALIDATE_URL);
                        $cleanFilePath = $isUrl
                            ? $dokumen->file_path
                            : (Str::startsWith($dokumen->file_path, 'dokumen/')
                                ? $dokumen->file_path
                                : 'dokumen/' . ltrim($dokumen->file_path, '/'));
                    @endphp

                    @if ($dokumen->file_path)
                        <a href="{{ $isUrl ? $cleanFilePath : asset($cleanFilePath) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                            Lihat {{ $isUrl ? 'Link' : 'File' }}
                        </a>
                    @elseif (!empty($dokumen->link))
                        <a href="{{ $dokumen->link }}" target="_blank" class="btn btn-sm btn-outline-info ms-2">
                            Kunjungi Link
                        </a>
                    @else
                        <span class="text-danger ms-2">File atau link tidak tersedia.</span>
                    @endif
                </div>

                {{-- Komentar Pengembalian jika ada --}}
                @if ($dokumen->status === 'dikembalikan' && $dokumen->komentar_pengembalian)
                    <div class="mb-2"><strong>Komentar Pengembalian</strong> : {{ $dokumen->komentar_pengembalian }}</div>
                @endif

                {{-- Status Dokumen --}}
                @if ($dokumen->status === 'disetujui')
                    <div class="alert alert-success mt-3">
                        Dokumen ini telah disetujui.
                    </div>
                @elseif ($dokumen->status === 'dikembalikan')
                    <div class="alert alert-warning mt-3">
                        Dokumen ini telah dikembalikan.
                    </div>
                @else
                    {{-- Tombol Validasi --}}
                    @if (in_array(auth()->user()->role, ['administrator', 'koordinator']))
                        <div class="mt-4">
                            <div class="mb-3">
                                <label for="komentar" class="form-label"><strong>Komentar Pengembalian</strong></label>
                                <form action="{{ route('dokumen.kembalikan', $dokumen->id) }}" method="POST">
                                    @csrf
                                    <textarea name="komentar" id="komentar" class="form-control mb-2" rows="3" placeholder="Tulis alasan pengembalian..."></textarea>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-danger">Kembalikan Dokumen</button>
                                </form>

                                {{-- Form Setujui --}}
                                <form action="{{ route('dokumen.setujui', $dokumen->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Setujui Dokumen</button>
                                </form>
                                    </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger mt-3">
                            <strong>Maaf!</strong> Anda tidak memiliki akses untuk memvalidasi dokumen ini.
                        </div>
                    @endif
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            <strong>Peringatan!</strong> Dokumen yang dimaksud tidak ditemukan atau tidak tersedia untuk divalidasi.
        </div>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
