@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Detail Dokumen : {{ $kriteria->nama }}</h1>

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
                            <th>Isi Dokumen</th>
                            <th>Tanggal Upload</th>
                            <th>Dokumen</th>
                            <th>Komentar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $key => $document)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $document->judul }}</td>
                                <td>{{ $document->deskripsi ?? '-' }}</td>
                                <td>
                                    @if($document->isi)
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#isiModal{{ $document->id }}">
                                            Lihat Isi
                                        </button>

                                        <!-- Modal untuk menampilkan isi -->
                                        <div class="modal fade" id="isiModal{{ $document->id }}" tabindex="-1" aria-labelledby="isiModalLabel{{ $document->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="isiModalLabel{{ $document->id }}">{{ $document->judul }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! $document->isi !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $document->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @php
                                        $filePath = $document->file_path;
                                        $linkPath = $document->link;
                                        $isUrlFile = $filePath && Str::startsWith($filePath, ['http://', 'https://']);
                                        $isUrlLink = $linkPath && Str::startsWith($linkPath, ['http://', 'https://']);
                                    @endphp

                                    @if ($isUrlFile)
                                        <a href="{{ $filePath }}" target="_blank" class="btn btn-primary btn-sm">
                                            <i class="fas fa-external-link-alt"></i> Lihat File (URL)
                                        </a>
                                    @elseif ($filePath && file_exists(public_path($filePath)))
                                        <a href="{{ asset($filePath) }}" target="_blank" class="btn btn-primary btn-sm">
                                            <i class="fas fa-file"></i> Lihat File
                                        </a>
                                    @elseif ($isUrlLink)
                                        <a href="{{ $linkPath }}" target="_blank" class="btn btn-primary btn-sm">
                                            <i class="fas fa-link"></i> Lihat Link
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada file atau link</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Tampilkan Komentar --}}
                                    @if ($document->komentars && $document->komentars->count())
                                        <div class="comments-section">
                                            <button class="btn btn-outline-primary btn-sm mb-2" type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#comments{{ $document->id }}" 
                                                    aria-expanded="false">
                                                Lihat Komentar ({{ $document->komentars->count() }})
                                            </button>
                                            <div class="collapse" id="comments{{ $document->id }}">
                                                <ul class="list-unstyled comments-list" style="max-height:200px; overflow-y:auto;">
                                                    @foreach ($document->komentars->sortByDesc('created_at') as $komentar)
                                                        <li class="comment-item mb-2">
                                                            <div class="comment-header">
                                                                <strong>{{ $komentar->user->name }}</strong>
                                                                <small class="text-muted ms-2">{{ $komentar->created_at->diffForHumans() }}</small>
                                                            </div>
                                                            <div class="comment-body">
                                                                {{ $komentar->isi }}
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">Belum ada komentar.</span>
                                    @endif
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
                            <th>Dokumen</th>
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
                                    @php
                                        $filePath = $document->file_path;
                                        $linkPath = $document->link;
                                        $isUrlFile = $filePath && Str::startsWith($filePath, ['http://', 'https://']);
                                        $isUrlLink = $linkPath && Str::startsWith($linkPath, ['http://', 'https://']);
                                    @endphp

                                    @if ($isUrlFile)
                                        <a href="{{ $filePath }}" target="_blank">Lihat File (URL)</a>
                                    @elseif ($filePath && file_exists(public_path($filePath)))
                                        <a href="{{ asset($filePath) }}" target="_blank">Lihat File</a>
                                    @elseif ($isUrlLink)
                                        <a href="{{ $linkPath }}" target="_blank">Lihat Link</a>
                                    @else
                                        <span class="text-muted">Tidak ada file atau link yang tersedia</span>
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

                                    {{-- Form Tambah Komentar --}}
                                    @if (in_array(Auth::user()->role, ['administrator', 'kajur', 'kps', 'direktur', 'koordinator']))
                                        <form action="{{ route('komentar.store') }}" method="POST" class="mt-2">
                                            @csrf
                                            <input type="hidden" name="dokumen_id" value="{{ $document->id }}">
                                            <div class="input-group">
                                                <textarea name="isi" class="form-control form-control-sm" rows="2" 
                                                          placeholder="Tulis komentar..." required></textarea>
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
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

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
                                    {{-- Form Tambah Komentar --}}
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

@push('styles')
<style>
    .comments-list {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 0.5rem;
    }
    .comment-item {
        padding: 0.5rem;
        border-bottom: 1px solid #dee2e6;
    }
    .comment-item:last-child {
        border-bottom: none;
    }
    .comment-header {
        margin-bottom: 0.25rem;
    }
</style>
@endpush
@endsection