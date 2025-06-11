@extends('layouts.app')

@section('main-content')
<div class="container mt-5">
    <h2>Buat Dokumen Kriteria {{ $nomor }} Tahapan {{ ucfirst($tahap) }}</h2>

    {{-- Notifikasi Sukses / Gagal --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <strong>Gagal!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada kesalahan pada input:
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form id="formDokumen" method="POST">
        @csrf
        <input type="hidden" name="status" id="status">
        <input type="hidden" name="tahap" value="{{ $tahap }}">
        <input type="hidden" name="nomor" value="{{ $nomor }}">

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Dokumen</label>
            <input type="text" name="judul" id="judul" class="form-control" required value="{{ old('judul') }}">
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Dokumen</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="konten" class="form-label">Isi Dokumen</label>
            <textarea name="konten" id="konten" class="form-control" rows="12">{{ old('konten') }}</textarea>
        </div>

        {{-- Tombol Aksi --}}
        <div class="d-flex justify-content-start gap-2 mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
            <button type="button" class="btn btn-warning" onclick="submitForm('draft')">Simpan sebagai Draft</button>
            <button type="button" class="btn btn-success" onclick="submitForm('dikirim')">Submit</button>
        </div>
    </form>
</div>

{{-- TinyMCE --}}
<script src="/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#konten',
        height: 400,
        menubar: false,
        plugins: 'lists link image table code help wordcount',
        toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image | code',
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });

    function submitForm(status) {
        tinymce.triggerSave();

        const form = document.getElementById('formDokumen');
        const formData = new FormData(form);
        formData.set('status', status);

        fetch(`{{ route('dokumen.storeFromTemplate') }}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(async response => {
            const contentType = response.headers.get('content-type') || '';
            const isJson = contentType.includes('application/json');
            const data = isJson ? await response.json() : null;

            const alertContainer = document.createElement('div');
            if (response.ok) {
                alertContainer.className = 'alert alert-success mt-3';
                alertContainer.innerHTML = `<strong>Berhasil!</strong> ${data.message}`;
                form.reset();
                tinymce.get('konten').setContent('');

                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            } else {
                alertContainer.className = 'alert alert-danger mt-3';
                let errors = '';
                if (data?.errors) {
                    for (const err of Object.values(data.errors)) {
                        errors += `<li>${err}</li>`;
                    }
                } else {
                    errors += `<li>${data?.message ?? 'Terjadi kesalahan.'}</li>`;
                }
                alertContainer.innerHTML = `<ul>${errors}</ul>`;
            }

            const container = document.getElementById('formDokumen').parentElement;
            container.prepend(alertContainer);
        })
        .catch(error => {
            console.error('Submit Error:', error);
            const alert = document.createElement('div');
            alert.className = 'alert alert-danger mt-3';
            alert.innerHTML = 'Terjadi kesalahan. Coba lagi nanti.';
            document.getElementById('formDokumen').parentElement.prepend(alert);
        });
    }
</script>
@endsection
