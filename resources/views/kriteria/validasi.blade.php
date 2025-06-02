@extends('layouts.app')

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
                <div class="mb-2 d-flex">
                    <div style="width: 150px;"><strong>Kriteria</strong></div>
                    <div>: {{ $dokumen->kriteria->nama ?? '-' }}</div>
                </div>
                <div class="mb-2 d-flex">
                    <div style="width: 150px;"><strong>Deskripsi</strong></div>
                    <div>: {{ $dokumen->deskripsi ?? '-' }}</div>
                </div>
                <div class="mb-2 d-flex">
                    <div style="width: 150px;"><strong>Tanggal Upload</strong></div>
                    <div>: {{ $dokumen->created_at->format('d M Y H:i') }}</div>
                </div>

                @if ($dokumen->file_path)
                    <div class="mb-2 d-flex">
                        <div style="width: 150px;"><strong>File</strong></div>
                        <div>:
                            @if (filter_var($dokumen->file_path, FILTER_VALIDATE_URL))
                                <a href="{{ $dokumen->file_path }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Link</a>
                            @else
                                <a href="{{ asset('dokumen/' . $dokumen->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat File</a>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="text-danger">File tidak tersedia.</p>
                @endif

                {{-- Warning jika sudah disetujui atau dikembalikan --}}
                @if ($dokumen->status === 'disetujui')
                    <div class="alert alert-success">
                        Dokumen ini telah disetujui.
                    </div>
                @elseif ($dokumen->status === 'dikembalikan')
                    <div class="alert alert-warning">
                        Dokumen ini telah dikembalikan.
                        @if($dokumen->komentar_pengembalian)
                            <hr>
                            <p><strong>Alasan Pengembalian:</strong></p>
                            <p>{{ $dokumen->komentar_pengembalian }}</p>
                        @endif
                    </div>
                @else
                    {{-- Validasi hanya untuk administrator, koordinator, dan direktur --}}
                    @if (in_array(auth()->user()->role, ['administrator', 'koordinator', 'direktur']))
                        <div class="d-flex gap-2 mt-3">
                            {{-- Form Kembalikan --}}
                            <form action="{{ route('dokumen.kembalikan', $dokumen->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <div class="mb-2">
                                    <label for="komentar" class="form-label">Komentar Pengembalian</label>
                                    <textarea name="komentar" id="komentar" class="form-control" rows="3" placeholder="Tulis alasan pengembalian..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger">Kembalikan Dokumen</button>
                            </form>

                            {{-- Form Setujui --}}
                            <form action="{{ route('dokumen.setujui', $dokumen->id) }}" method="POST" class="d-flex align-items-end">
                                @csrf
                                <button type="submit" class="btn btn-success">Setujui Dokumen</button>
                            </form>
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
