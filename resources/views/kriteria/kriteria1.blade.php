@extends('layouts.app')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Data Kriteria 1</h1>

    @foreach ($kriterias as $table => $items)
    <h2 class="mt-4">Tabel: {{ $table }}</h2>
    <table class="table table-bordered kriteriaTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $kriteria)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kriteria->nama }}</td>
                    <td>
                        @php
                            $dokumenKriteria = $dokumen->where('kriteria_id', $kriteria->id)->first();
                        @endphp

                        @if ($dokumenKriteria)
                            <a href="{{ route('kriteria.lihat', $kriteria->id) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('dokumen.validasi', $kriteria->id) }}" class="btn btn-success btn-sm">Validasi</a>
                        @else
                            <span class="text-muted">Belum ada dokumen</span>
                        @endif

                        <a href="{{ route('dokumen.upload', $kriteria->id) }}" class="btn btn-primary btn-sm">Upload</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Komentar --}}
    <div class="mt-5">
        <h5>Komentar</h5>
        <ul class="list-group mb-3">
            @forelse ($komentars[$table] ?? [] as $komentar)
                <li class="list-group-item">
                    <strong>{{ $komentar->user->name }}</strong>: {{ $komentar->isi }}
                </li>
            @empty
                <li class="list-group-item text-muted">Belum ada komentar.</li>
            @endforelse
        </ul>

        <form method="POST" action="{{ route('komentar.store') }}">
            @csrf

            @php
                $dokumenPertama = $items->first()->dokumen ?? null;
            @endphp

            @if ($dokumenPertama)
                <input type="hidden" name="dokumen_id" value="{{ $dokumenPertama->id }}">
            @else
                <input type="hidden" name="dokumen_id" value="">
            @endif

            <input type="hidden" name="table" value="{{ $table }}">
            <div class="mb-2">
                <textarea name="isi" class="form-control" placeholder="Tulis komentar..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Kirim Komentar</button>
        </form>
    </div>
    <hr>
    @endforeach
</div>

@push('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />

<script>
    $(document).ready(function () {
        $('.kriteriaTable').DataTable();
    });
</script>
@endpush
@endsection
