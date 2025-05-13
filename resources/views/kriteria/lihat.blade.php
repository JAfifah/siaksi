@extends('layouts.app')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Detail Dokumen : {{$kriterias->nama}}</h1>

    @if ($documents->isEmpty())
        <div class="alert alert-warning">
            Dokumen tidak tersedia atau belum diupload.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Dokumen</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Upload</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $key => $document)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $document->judul }}</td>
                        <td>{{ $document->deskripsi ?? '-' }}</td>
                        <td>{{ $document->created_at->format('d M Y H:i') }}</td>
                        <td>
                            @if ($document->file_path)
                                <a href="{{ asset('dokumen/' . $document->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat File</a>
                            @else
                                <span class="text-muted">Tidak ada file yang diupload</span>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
