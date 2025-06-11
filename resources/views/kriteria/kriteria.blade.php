@extends('layouts.app')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Data Kriteria {{ $nomor }}</h1>

    @php
        $tahapan = ['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'];
        $semuaDisetujui = true;
        $sudahFinalisasi = false;

        foreach ($kriterias as $kriteria) {
            $dok = collect($dokumen)->where('kriteria_id', $kriteria->id)->first();
            if (!$dok || $dok->status !== 'disetujui') {
                $semuaDisetujui = false;
            }
            if ($kriteria->finalisasi_disetujui ?? false) {
                $sudahFinalisasi = true;
            }
        }
    @endphp

    @if ($sudahFinalisasi)
        <div class="alert alert-info">
            <i class="fas fa-check-circle"></i> Kriteria ini sudah difinalisasi.
        </div>
    @endif

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
                            <th>Nama Data Pendukung</th>
                            <th>Status Validasi</th>
                            <th width="35%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kriterias->where('tahap', $tahap) as $kriteria)
                            @php 
                                $dokumenKriteria = collect($dokumen)->where('kriteria_id', $kriteria->id)->first(); 
                                $status = $dokumenKriteria->status ?? null;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dokumenKriteria->judul ?? 'Belum ada dokumen' }}</td>
                                <td>
                                    @if ($status)
                                        @switch($status)
                                            @case('disetujui')
                                                <span class="badge badge-success">Disetujui</span>
                                                @break
                                            @case('dikembalikan')
                                                <span class="badge badge-warning">Dikembalikan</span>
                                                @break
                                            @case('dikirim')
                                                <span class="badge badge-info">Dikirim</span>
                                                @break
                                            @case('draft')
                                                <span class="badge badge-secondary">Draft</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ ucfirst($status) }}</span>
                                        @endswitch
                                    @else
                                        <span class="text-muted">Belum divalidasi</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap" style="gap: 0.5rem;">
                                        @if ($dokumenKriteria)
                                            @if ($status === 'draft')
                                                <a href="{{ route('dokumen.edit', $dokumenKriteria->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            @else
                                                <a href="{{ route('dokumen.lihat', $dokumenKriteria->kriteria_id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            @endif

                                            @if ($status !== 'disetujui')
                                                <a href="{{ route('dokumen.validasi', $dokumenKriteria->id) }}" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i> Validasi
                                                </a>
                                            @endif

                                            @if (in_array($status, ['dikembalikan', 'draft']) || is_null($status))
                                                <a href="{{ route('dokumen.edit', $dokumenKriteria->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Update
                                                </a>
                                            @endif

                                            @if ($status !== 'disetujui')
                                                <form action="{{ route('dokumen.destroy', $dokumenKriteria->id) }}" method="POST" 
                                                      onsubmit="return confirm('Yakin ingin menghapus dokumen dan kriteria ini?')" 
                                                      style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        @elseif (in_array(auth()->user()->role, ['administrator', 'anggota']))
                                            <a href="{{ route('kriteria.edit', $kriteria->id) }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-pen"></i> Edit Kriteria
                                            </a>
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

            @if (in_array(auth()->user()->role, ['administrator', 'anggota']))
                <a href="{{ route('kriteria.create', ['tahap' => $tahap, 'nomor' => $nomor]) }}" class="btn btn-sm btn-primary m-3">
                    <i class="fas fa-plus"></i> Tambah Dokumen
                </a>
            @endif
        </div>
    @endforeach

    @if (in_array(auth()->user()->role, ['administrator', 'koordinator']))
        <div class="text-end mt-4">
            @if ($sudahFinalisasi)
                {{-- Sudah finalisasi --}}
            @elseif ($semuaDisetujui)
                <form action="{{ route('finalisasi.kirim', ['nomor' => $nomor]) }}" method="POST" 
                      onsubmit="return confirm('Yakin ingin menyerahkan finalisasi ke direktur?')">
                    @csrf
                    <button type="submit" class="btn btn-lg btn-success">
                        <i class="fas fa-paper-plane"></i> Kirim Finalisasi ke Direktur
                    </button>
                </form>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle"></i> Semua dokumen harus disetujui sebelum mengirim finalisasi.
                </div>
            @endif
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mt-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
</div>
@endsection
