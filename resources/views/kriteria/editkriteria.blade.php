@extends('layouts.app')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Edit Kriteria</h1>

    <form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="nama">Nama Kriteria</label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" 
                   value="{{ old('nama', $kriteria->nama) }}" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="tahap">Tahapan</label>
            <select name="tahap" id="tahap" class="form-control @error('tahap') is-invalid @enderror" required>
                <option value="">-- Pilih Tahapan --</option>
                @foreach (['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'] as $tahap)
                    <option value="{{ $tahap }}" {{ old('tahap', $kriteria->tahap) == $tahap ? 'selected' : '' }}>
                        {{ ucfirst($tahap) }}
                    </option>
                @endforeach
            </select>
            @error('tahap')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
