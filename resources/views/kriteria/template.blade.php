@extends('layouts.app')

@section('main-content')
<div class="container mt-5">
    <h2>Buat Dokumen</h2>

    {{-- Notifikasi --}}
    <div id="alert-container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div>

    {{-- Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada kesalahan:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form id="formDokumen" method="POST">
        @csrf
        <input type="hidden" name="status" id="status" value="">

        {{-- Pilih Kriteria --}}
        <div class="mb-3">
            <label for="kriteria_id" class="form-label">Pilih Kriteria</label>
            <select name="kriteria_id" id="kriteria_id" class="form-select" required>
                <option value="">-- Pilih --</option>
                @for ($i = 1; $i <= 9; $i++)
                    <option value="{{ $i }}">{{ 'Kriteria ' . $i }}</option>
                @endfor
            </select>
        </div>

        {{-- Pilih Tahapan --}}
        <div class="mb-3">
            <label for="tahap" class="form-label">Pilih Tahapan</label>
            <select name="tahap" id="tahap" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="penetapan">Penetapan</option>
                <option value="pelaksanaan">Pelaksanaan</option>
                <option value="evaluasi">Evaluasi</option>
                <option value="pengendalian">Pengendalian</option>
                <option value="peningkatan">Peningkatan</option>
            </select>
        </div>

        {{-- Judul --}}
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Dokumen</label>
            <input type="text" name="judul" id="judul" class="form-control" required value="{{ old('judul') }}">
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi') }}</textarea>
        </div>

        {{-- Isi Dokumen --}}
        <div class="mb-3">
            <label for="isi" class="form-label">Isi Dokumen</label>
            <textarea name="isi" id="isi" class="form-control" rows="10">{{ old('isi') }}</textarea>
        </div>

        {{-- Tombol --}}
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-success" onclick="submitForm('dikirim')">Submit</button>
        </div>
    </form>
</div>

{{-- TinyMCE --}}
<script src="/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#isi',
        height: 400,
        menubar: false,
        plugins: 'lists link image table code help wordcount',
        toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image | code',
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave(); // pastikan textarea ikut terupdate
            });
        }
    });

    function submitForm(status) {
        tinymce.triggerSave();

        const form = document.getElementById('formDokumen');
        const formData = new FormData(form);
        formData.set('status', status);

        fetch(`{{ route('kriteria.storeFromTemplate') }}`, {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: formData
})
.then(async response => {
    const alertContainer = document.getElementById('alert-container');
    alertContainer.innerHTML = '';

    const contentType = response.headers.get('content-type') || '';
    const isJson = contentType.includes('application/json');
    const data = isJson ? await response.json() : {};

    if (response.ok) {
        const message = data.message || 'Dokumen berhasil disimpan.';
        alertContainer.innerHTML = `<div class="alert alert-success"><i class="fas fa-check-circle"></i> ${message}</div>`;
        form.reset();
        tinymce.get('isi').setContent('');

        if (data.redirect) {
            window.location.href = data.redirect;
        }
    } else {
        let errors = '';
        if (data?.errors) {
            for (const err of Object.values(data.errors)) {
                errors += `<li>${err}</li>`;
            }
        } else {
            errors += `<li>${data?.message ?? 'Terjadi kesalahan.'}</li>`;
        }
        alertContainer.innerHTML = `<div class="alert alert-danger"><ul>${errors}</ul></div>`;
    }
})
.catch(error => {
    document.getElementById('alert-container').innerHTML = 
        `<div class="alert alert-danger">Terjadi kesalahan jaringan. Coba lagi nanti.</div>`;
    console.error('Submit Error:', error);
});

    }
</script>
@endsection
