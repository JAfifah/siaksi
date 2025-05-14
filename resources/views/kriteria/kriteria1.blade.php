@extends('layouts.app')

@section('main-content')
<div class="container">
    <h1 class="mb-4">Data Kriteria 1</h1>

    @foreach ($kriterias as $table => $items)
    <h2 class="mt-4">Penetapan {{ $table }}</h2>
    <table class="table table-bordered kriteriaTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $item1 = $items[0] ?? null; @endphp
            @php $item2 = $items[1] ?? null; @endphp
            @php $item3 = $items[2] ?? null; @endphp

            #kolom1
            @if ($item1)
            <tr>
                <td>1</td>
                <td>Kriteria Penilaian Dosen</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item1->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item1->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item1->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item1->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif

            #Kolom2
            @if ($item2)
            <tr>
                <td>2</td>
                <td>Kriteria Kinerja Mahasiswa</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item2->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item2->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item2->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item2->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif

            @if ($item3)
            <tr>
                <td>3</td>
                <td>Kriteria Sarana dan Prasarana</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item3->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item3->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item3->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item3->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif

            @if ($item1)
            <tr>
                <td>4</td>
                <td>Kriteria Penilaian Dosen</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item1->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item1->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item1->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item1->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif


        </tbody>
    </table>


    
    @endforeach

    @foreach ($kriterias as $table => $items)
    <h2 class="mt-4">Pelaksanaan {{ $table }}</h2>
    <table class="table table-bordered kriteriaTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $item1 = $items[0] ?? null; @endphp
            @php $item2 = $items[1] ?? null; @endphp
            @php $item3 = $items[2] ?? null; @endphp

            @if ($item1)
            <tr>
                <td>1</td>
                <td>Kriteria Penilaian Dosen</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item1->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item1->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item1->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item1->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif

            @if ($item2)
            <tr>
                <td>2</td>
                <td>Kriteria Kinerja Mahasiswa</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item2->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item2->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item2->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item2->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif

            @if ($item3)
            <tr>
                <td>3</td>
                <td>Kriteria Sarana dan Prasarana</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item3->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item3->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item3->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item3->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif

            @if ($item3)
            <tr>
                <td>4</td>
                <td>Kriteria Sarana dan Prasarana</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item3->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item3->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item3->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item3->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif
        </tbody>
    </table>

     @endforeach

    @foreach ($kriterias as $table => $items)
    <h2 class="mt-4">Evaluasi {{ $table }}</h2>
    <table class="table table-bordered kriteriaTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $item1 = $items[0] ?? null; @endphp
            @php $item2 = $items[1] ?? null; @endphp
            @php $item3 = $items[2] ?? null; @endphp

            @if ($item1)
            <tr>
                <td>1</td>
                <td>Kriteria Penilaian Dosen</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item1->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item1->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item1->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item1->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif

            @if ($item2)
            <tr>
                <td>2</td>
                <td>Kriteria Kinerja Mahasiswa</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item2->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item2->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item2->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item2->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif

            @if ($item3)
            <tr>
                <td>3</td>
                <td>Kriteria Sarana dan Prasarana</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item3->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item3->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item3->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item3->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif
        </tbody>
    </table>

     @endforeach

    @foreach ($kriterias as $table => $items)
    <h2 class="mt-4">Pengendalian {{ $table }}</h2>
    <table class="table table-bordered kriteriaTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $item1 = $items[0] ?? null; @endphp
            @php $item2 = $items[1] ?? null; @endphp
            @php $item3 = $items[2] ?? null; @endphp

            @if ($item1)
            <tr>
                <td>1</td>
                <td>Kriteria Penilaian Dosen</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item1->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item1->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item1->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item1->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif

            @if ($item2)
            <tr>
                <td>2</td>
                <td>Kriteria Kinerja Mahasiswa</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item2->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item2->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item2->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item2->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif

            @if ($item3)
            <tr>
                <td>3</td>
                <td>Kriteria Sarana dan Prasarana</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item3->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item3->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item3->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item3->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif
        </tbody>
    </table>

     @endforeach

    @foreach ($kriterias as $table => $items)
    <h2 class="mt-4">Peningkatan {{ $table }}</h2>
    <table class="table table-bordered kriteriaTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $item1 = $items[0] ?? null; @endphp
            @php $item2 = $items[1] ?? null; @endphp
            @php $item3 = $items[2] ?? null; @endphp

            @if ($item1)
            <tr>
                <td>1</td>
                <td>Kriteria Penilaian Dosen</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item1->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item1->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item1->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item1->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif

            @if ($item2)
            <tr>
                <td>2</td>
                <td>Kriteria Kinerja Mahasiswa</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item2->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item2->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item2->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item2->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif

            @if ($item3)
            <tr>
                <td>3</td>
                <td>Kriteria Sarana dan Prasarana</td>
                <td>
                    @php $dokumenKriteria = collect($dokumen)->where('kriteria_id', $item3->id)->first(); @endphp
                    @if ($dokumenKriteria)
                        <a href="{{ route('kriteria.lihat', $item3->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('dokumen.validasi', $item3->id) }}" class="btn btn-success btn-sm">Validasi</a>
                    @else
                        <span class="text-muted">Belum ada dokumen</span>
                    @endif
                    <a href="{{ route('dokumen.upload', $item3->id) }}" class="btn btn-primary btn-sm">Upload</a>
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- Komentar --}}
    <div class="mt-5">
        <h5>Komentar</h5>
        <ul class="list-group mb-3">
            @forelse ($komentars[$table] ?? [] as $komentar)
                <li class="list-group-item">
                    <strong>{{ $komentar->user->name }}</strong>: {{ $komentar->isi }}
                </li>
            @empty
                <li class="list-group-item text-muted">Belum ada komentar.</li>
            @endforelse
        </ul>

        <form method="POST" action="{{ route('komentar.store') }}">
            @csrf

            @php
                $dokumenPertama = $items->first()->dokumen ?? null;
            @endphp

            <input type="hidden" name="dokumen_id" value="{{ $dokumenPertama->id ?? '' }}">
            <input type="hidden" name="table" value="{{ $table }}">

            <div class="mb-2">
                <textarea name="isi" class="form-control" placeholder="Tulis komentar..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Kirim Komentar</button>
        </form>
    </div>
    <hr>
    @endforeach

</div>

@push('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />

<script>
    $(document).ready(function () {
        $('.kriteriaTable').DataTable();
    });
</script>
@endpush

@endsection