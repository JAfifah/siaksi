@extends('layouts.app')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Detail Dokumen : {{ $kriterias->nama }}</h1>

    <div class="card">
        <div class="card-body">
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
                            <th>Komentar</th>
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
                                <td>
                                    {{-- Tampilkan Komentar --}}
                                    @if ($document->komentars && $document->komentars->count())
                                        <ul class="list-unstyled mb-2" style="max-height:120px; overflow-y:auto;">
                                        @foreach ($document->komentars->sortByDesc('created_at') as $komentar)
                                                <li>
                                                    <strong>{{ $komentar->user->name }}</strong>: {{ $komentar->isi }}<br>
                                                    <small class="text-muted">{{ $komentar->created_at->diffForHumans() }}</small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">Belum ada komentar.</span>
                                    @endif

                                    {{-- Form Tambah Komentar untuk Admin, Kajur, KPS, Direktur --}}
                                    @if (in_array(Auth::user()->role, ['administrator', 'kajur', 'kps', 'direktur', 'koordinator']))
                                        <form action="{{ route('komentar.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="dokumen_id" value="{{ $document->id }}">
                                            <textarea name="isi" class="form-control mb-2" rows="2" placeholder="Tulis komentar..." required></textarea>
                                            <button type="submit" class="btn btn-sm btn-primary">Kirim</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection

