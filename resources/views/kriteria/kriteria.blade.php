@extends('layouts.app')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Data Kriteria {{ $nomor }}</h1>

    @php
        $tahapan = ['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'];
    @endphp

    @foreach ($tahapan as $tahap)
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title text-capitalize mb-0">{{ $tahap }}</h3>
            </div>
            
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Dokumen</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kriterias->where('tahap', $tahap) as $kriteria)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kriteria->nama }}</td>
                                <td>
                                    @php 
                                        $dokumenKriteria = collect($dokumen)
                                            ->where('kriteria_id', $kriteria->id)
                                            ->first(); 
                                    @endphp
                                    
                                    @if ($dokumenKriteria)
                                        <a href="{{ route('kriteria.lihat', $kriteria->id) }}" 
                                           class="btn btn-info btn-sm">
                                           <i class="fas fa-eye"></i> Lihat
                                        </a>
                                        {{-- Perbaikan di sini: gunakan dokumenKriteria->id --}}
                                        <a href="{{ route('dokumen.validasi', $dokumenKriteria->id) }}" 
                                           class="btn btn-success btn-sm">
                                           <i class="fas fa-check"></i> Validasi
                                        </a>
                                    @else
                                        <span class="text-muted">Belum ada dokumen</span>
                                    @endif
                                    
                                    <a href="{{ route('dokumen.upload', $kriteria->id) }}" 
                                       class="btn btn-primary btn-sm">
                                       <i class="fas fa-upload"></i> Upload
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data untuk tahap ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    <!-- Comments Section -->
    <div class="card mt-4">
        <div class="card-header">
            <h4>Komentar Kriteria {{ $nomor }}</h4>
        </div>
        <div class="card-body">
            <ul class="list-group mb-3">
                @forelse ($komentars as $komentar)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $komentar->user->name }}</strong>
                            <small class="text-muted">{{ $komentar->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-0">{{ $komentar->isi }}</p>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Belum ada komentar</li>
                @endforelse
            </ul>

            @if (isset($dokumenKriteria) && $dokumenKriteria)
                <form method="POST" action="{{ route('komentar.store') }}">
                    @csrf
                    <input type="hidden" name="page" value="{{ $nomor }}">
                    <input type="hidden" name="dokumen_id" value="{{ $dokumenKriteria->id }}">
                    <div class="form-group">
                        <textarea name="isi" class="form-control" rows="3" placeholder="Tulis komentar..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Kirim Komentar</button>
                </form>
            @else
                <div class="alert alert-warning">
                    Belum ada dokumen yang bisa dikomentari.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
