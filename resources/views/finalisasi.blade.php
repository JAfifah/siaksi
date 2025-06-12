@extends('layouts.app')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Finalisasi Kriteria</h1>

    @if(!in_array(auth()->user()->role, ['administrator', 'direktur']))
        <div class="alert alert-danger">
            Anda tidak memiliki akses ke halaman ini.
        </div>
    @else
        @php
            $totalKriteria = $kriterias->flatten()->count();
        @endphp

        @if($totalKriteria === 0)
            <div class="alert alert-info">
                Belum ada kriteria yang perlu divalidasi.
            </div>
        @endif

        @forelse($kriterias as $nomor => $kriteriaGroup)
            @if($kriteriaGroup->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Kriteria Nomor {{ $nomor }}</h5>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped mb-3">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Data Pendukung</th>
                                    <th>Tahapan</th>
                                    <th>Status Finalisasi</th>
                                    <th>Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kriteriaGroup as $index => $kriteria)
                                    @php
                                        $dokumen = $kriteria->dokumen->first(); // ambil 1 dokumen dari koleksi
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if ($dokumen && $dokumen->judul)
                                                {{ $dokumen->judul }}
                                            @else
                                                <em class="text-muted">Belum ada judul</em>
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($kriteria->tahap) }}</td>
                                        <td>
                                            @if ($kriteria->finalisasi_disetujui)
                                                <span class="badge badge-success">Disetujui</span>
                                            @else
                                                <span class="badge badge-warning">Menunggu</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($dokumen && $dokumen->file_path)
                                                <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank">
                                                    Lihat Dokumen
                                                </a>
                                            @else
                                                <span class="text-muted">Belum ada dokumen</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @php
                            $sudahDisetujui = $kriteriaGroup->every(fn($k) => $k->finalisasi_disetujui);
                            $idKriteriaPertama = $kriteriaGroup->first()->id;
                        @endphp

                        @if (!$sudahDisetujui && in_array(auth()->user()->role, ['administrator', 'direktur']))
                            <div class="mt-3">
                                <form action="{{ route('finalisasi.setujui', $idKriteriaPertama) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Setujui Kriteria
                                    </button>
                                </form>
                                <form action="{{ route('finalisasi.kembalikan', $idKriteriaPertama) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin mengembalikan semua dokumen pada kriteria ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-times"></i> Kembalikan Kriteria
                                    </button>
                                </form>
                            </div>
                        @elseif ($sudahDisetujui)
                            <div class="mt-3">
                                <span class="badge badge-success">Kriteria telah disetujui</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @empty
            <div class="alert alert-info">
                Tidak ada kriteria yang menunggu finalisasi.
            </div>
        @endforelse
    @endif
</div>
@endsection
