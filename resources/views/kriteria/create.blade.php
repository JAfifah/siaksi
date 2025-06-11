@extends('layouts.app')

@section('main-content')
<div class="container mt-5">
    <h2>Upload Dokumen Kriteria {{ $nomor }} {{ ucfirst($tahap) }}</h2>

    {{-- Alert sukses upload --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Alert gagal jika ada --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <strong>Gagal!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (in_array(auth()->user()->role, ['anggota', 'administrator']))
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

        {{-- Form Simpan Kriteria + Upload Dokumen --}}
        <form id="formKriteria" action="{{ route('kriteria.storeWithDokumen') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Hidden input status --}}
            <input type="hidden" name="status" id="status" value="">

            {{-- Hidden input tahap dan nomor --}}
            <input type="hidden" name="tahap" value="{{ $tahap }}">
            <input type="hidden" name="nomor" value="{{ $nomor }}">

            {{-- Data Dokumen --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <strong>Upload Dokumen</strong>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Dokumen</label>
                        <input type="text" id="judul" name="judul" class="form-control" required value="{{ old('judul') }}">
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Dokumen</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Upload File</label>
                        <label class="btn btn-outline-primary">
                            Pilih File
                            <input type="file" id="file" name="file" accept=".pdf,.doc,.docx,.jpg,.png,.zip" hidden onchange="tampilkanNamaFile()">
                        </label>
                        <span id="namaFile" class="ms-2 text-muted fst-italic"></span>
                        <div class="form-text">Format: pdf, doc, docx, jpg, png, zip. Maksimal 2MB.</div>
                    </div>

                    <div class="text-center mb-2">
                        <strong>— ATAU —</strong>
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label">Link Dokumen</label>
                        <input type="url" id="link" name="link" class="form-control" placeholder="https://contoh.com/dokumen" value="{{ old('link') }}">
                        <div class="form-text">Isi salah satu: file <em>atau</em> link.</div>
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-start gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                <button type="button" class="btn btn-success" onclick="submitForm('dikirim')">Submit</button>
            </div>
        </form>
    @else
        <div class="alert alert-danger mt-3">
            <strong>Maaf!</strong> Anda tidak memiliki akses.
        </div>
    @endif
</div>

{{-- Script untuk set value status dan submit form --}}
<script>
    function submitForm(statusValue) {
        document.getElementById('status').value = statusValue;
        document.getElementById('formKriteria').submit();
    }

    function tampilkanNamaFile() {
        const input = document.getElementById('file');
        const span = document.getElementById('namaFile');
        if (input.files.length > 0) {
            span.textContent = input.files[0].name;
        } else {
            span.textContent = '';
        }
    }
</script>
@endsection
