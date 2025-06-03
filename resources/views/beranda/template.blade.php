@extends('layouts.app')

@section('head')
<!-- Tambahkan TinyMCE -->
<script src="https://cdn.tiny.cloud/1/diounlkycysr9wlslzyxtyp3my4u037y6dhrdqau0hg8omex/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea.tinymce-editor',
    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
    height: 300
  });
</script>
@endsection

@section('content')
<div class="container">
    <h2>Upload Dokumen Baru</h2>

    <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Judul Dokumen -->
        <div class="form-group mb-3">
            <label for="judul">Judul Dokumen</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <!-- Kriteria -->
        <div class="form-group mb-3">
            <label for="kriteria_id">Pilih Kriteria</label>
            <select name="kriteria_id" class="form-control" required>
                <option value="">-- Pilih Kriteria --</option>
                @foreach($kriterias as $kriteria)
                    <option value="{{ $kriteria->id }}">{{ $kriteria->nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tahapan -->
        <div class="form-group mb-3">
            <label for="tahapan_id">Pilih Tahapan</label>
            <select name="tahapan_id" class="form-control" required>
                <option value="">-- Pilih Tahapan --</option>
                @foreach($tahapans as $tahapan)
                    <option value="{{ $tahapan->id }}">{{ $tahapan->nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- Deskripsi dengan TinyMCE -->
        <div class="form-group mb-3">
            <label for="deskripsi">Deskripsi Dokumen</label>
            <textarea name="deskripsi" class="form-control tinymce-editor"></textarea>
        </div>

        <!-- Upload File -->
        <div class="form-group mb-3">
            <label for="file_path">Upload File</label>
            <input type="file" name="file_path" class="form-control" required>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Unggah</button>
    </form>
</div>
@endsection
