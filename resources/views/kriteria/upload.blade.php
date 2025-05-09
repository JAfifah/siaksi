@extends('layouts.app')

@section('main-content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Upload Dokumen</h4>
                </div>

                <div class="card-body">

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

                    {{-- Form upload dokumen --}}
                    <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Dokumen</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Dokumen</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label d-block">Upload File</label>
                            
                            <!-- Tombol kustom untuk input file -->
                            <label class="btn btn-outline-primary">
                                Pilih File
                                <input type="file" name="file" id="file" accept=".pdf,.doc,.docx,.jpg,.png" hidden required>
                            </label>
                            <div class="form-text mt-1">Format diperbolehkan: pdf, doc, docx, jpg, png. Maksimal 2MB.</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
    </div>
@endif

@endsection
