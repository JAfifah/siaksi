@extends('layouts.app')

@section('main-content')
<div class="container">
    <h1>Tambah Kriteria</h1>

    <p>Tahap: <strong>{{ $tahap }}</strong></p>
    <p>Nomor: <strong>{{ $nomor }}</strong></p>

    <form action="{{ route('kriteria.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nama">Nama Kriteria</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>

        <input type="hidden" name="tahap" value="{{ $tahap }}">
        <input type="hidden" name="nomor" value="{{ $nomor }}">

        <button type="submit" class="btn btn-primary mt-2">Simpan</button>
    </form>
</div>

@endsection

