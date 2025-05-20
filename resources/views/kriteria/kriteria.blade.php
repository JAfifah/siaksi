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
                            <th>Status Validasi</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kriterias->where('tahap', $tahap) as $kriteria)
                            @php 
                                $dokumenKriteria = collect($dokumen)
                                    ->where('kriteria_id', $kriteria->id)
                                    ->first(); 
                                $status = $dokumenKriteria->status ?? null;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kriteria->nama }}</td>
                                
                                <td>
                                    @if ($status)
                                        @if ($status == 'disetujui')
                                            <span class="badge badge-success">Disetujui</span>
                                        @elseif ($status == 'dikembalikan')
                                            <span class="badge badge-warning">Dikembalikan</span>
                                        @elseif ($status == 'dikirim')
                                            <span class="badge badge-info">Dikirim</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($status) }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">Belum divalidasi</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($dokumenKriteria)
                                        <a href="{{ route('kriteria.lihat', $kriteria->id) }}" 
                                           class="btn btn-info btn-sm">
                                           <i class="fas fa-eye"></i> Lihat
                                        </a>

                                        @if ($status !== 'disetujui')
                                            <a href="{{ route('dokumen.validasi', $dokumenKriteria->id) }}" 
                                               class="btn btn-success btn-sm">
                                               <i class="fas fa-check"></i> Validasi
                                            </a>
                                        @endif

                                        @if ($status === 'dikembalikan')
                                            <a href="{{ route('kriteria.edit', $dokumenKriteria->id) }}" 
                                               class="btn btn-warning btn-sm">
                                               <i class="fas fa-edit"></i> Update
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-muted">Belum ada dokumen</span>
                                        <a href="{{ route('dokumen.upload', $kriteria->id) }}" 
                                           class="btn btn-primary btn-sm">
                                           <i class="fas fa-upload"></i> Upload
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data untuk tahap ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection
