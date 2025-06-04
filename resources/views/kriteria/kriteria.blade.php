@extends('layouts.app')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Data Kriteria {{ $nomor }}</h1>

    @php
        $tahapan = ['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'];
    @endphp

    @foreach ($tahapan as $tahap)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title text-capitalize mb-0">{{ $tahap }}</h3>
            </div>
            
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Dokumen</th>
                            <th>Status Validasi</th>
                            <th width="35%">Aksi</th>
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
                                    <div class="d-flex flex-wrap" style="gap: 0.5rem;">
                                        @if ($dokumenKriteria)
                                            <a href="{{ route('kriteria.lihat', ['nomor' => $nomor, 'id' => $kriteria->id]) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>

                                            @if ($status !== 'disetujui')
                                                <a href="{{ route('dokumen.validasi', $dokumenKriteria->id) }}" 
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i> Validasi
                                                </a>
                                            @endif

                                            @if ($status === 'dikembalikan' || is_null($status))
                                                <a href="{{ route('dokumen.edit', $dokumenKriteria->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Update
                                                </a>
                                            @endif
                                        @elseif (in_array(auth()->user()->role, ['administrator', 'anggota']))
                                            <a href="{{ route('kriteria.edit', $kriteria->id) }}" 
                                               class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-pen"></i> Edit Kriteria
                                            </a>

                                            <form action="{{ route('kriteria.destroy', $kriteria->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus kriteria ini?')" 
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
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

            {{-- Tombol tambah kriteria hanya untuk administrator dan anggota --}}
            @if (in_array(auth()->user()->role, ['administrator', 'anggota']))
                <a href="{{ route('kriteria.create', ['tahap' => $tahap, 'nomor' => $nomor]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah Dokumen
                </a>
            @endif
        </div>
    @endforeach

    @if ($errors->any())
    <div class="alert alert-danger mt-2">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection
