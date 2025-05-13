@extends('layouts.app')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Data Kriteria 1</h1>

    <table class="table table-bordered kriteriaTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kriterias as $kriteria)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kriteria->nama }}</td>
                <td>
                    @if ($kriteria->dokumen)
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
            @forelse ($komentars as $komentar)
                <li class="list-group-item">
                    <strong>{{ $komentar->user->name }}</strong>: {{ $komentar->isi }}
                </li>
            @empty
                <li class="list-group-item text-muted">Belum ada komentar.</li>
            @endforelse
        </ul>

        <form method="POST" action="{{ route('komentar.store') }}">
    @csrf

    @if ($dokumen->isNotEmpty())
        <!-- Mengambil dokumen pertama dari koleksi -->
        <input type="hidden" name="dokumen_id" value="{{ $dokumen->first()->id }}"> <!-- Dokumen pertama -->
    @else
        <input type="hidden" name="dokumen_id" value="null"> <!-- Atau menampilkan error jika tidak ada dokumen -->
    @endif

    <div class="mb-2">
        <textarea name="isi" class="form-control" placeholder="Tulis komentar..."></textarea>
    </div>

    <button type="submit" class="btn btn-primary btn-sm">Kirim Komentar</button>
</form>

    </div>
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
