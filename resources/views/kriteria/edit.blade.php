@extends('layouts.app')

@section('main-content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Update Dokumen</h4>
                </div>

                <div class="card-body">

                    {{-- Cek apakah user boleh mengedit --}}
                    @if (auth()->user()->role === 'anggota' || auth()->user()->role === 'administrator')

                        {{-- Tampilkan error validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h6><strong>Oops!</strong> Ada kesalahan pada input:</h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Form edit dokumen --}}
                        <form action="{{ route('dokumen.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="kriteria_id" value="{{ $dokumen->kriteria_id }}">

                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Dokumen</label>
                                <input type="text" name="judul" class="form-control" value="{{ $dokumen->judul }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Dokumen</label>
                                <textarea name="deskripsi" class="form-control" rows="4" required>{{ $dokumen->deskripsi }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label d-block">Upload File Baru (Opsional)</label>
                                <label class="btn btn-outline-primary">
                                    Pilih File
                                    <input type="file" name="file" id="file" accept=".pdf,.doc,.docx,.jpg,.png" hidden>
                                </label>
                                <div class="form-text mt-1">Format: pdf, doc, docx, jpg, png. Maksimal 2MB.</div>
                            </div>

                            <div class="text-center mb-2">
                                <strong>— ATAU —</strong>
                            </div>

                            <div class="mb-3">
                                <label for="link" class="form-label">Link Dokumen (Opsional)</label>
                                <input type="url" name="link" class="form-control" value="{{ $dokumen->link }}" placeholder="https://contoh.com/dokumen">
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ url('/kriteria/kriteria.blade.php') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-warning">Update</button>
                            </div>
                        </form>

                    @else
                        <div class="alert alert-danger">
                            Anda tidak memiliki izin untuk mengedit dokumen ini.
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
