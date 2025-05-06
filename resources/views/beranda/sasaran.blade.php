@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid text-center">
            <h1 class="display-4 font-weight-bold">Sasaran D4 Sistem Informasi Bisnis</h1>
        </div>
    </div>
@endsection

@section('main-content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h3 class="font-weight-bold mb-3">Sasaran</h3>
                        <ol style="font-size: 1.5rem;">
                            <li>Meningkatnya akses relevansi, kuantitas, dan kualitas Pendidikan Program Studi D4 - SIB</li>
                            <li>Meningkatnya relevansi dan kualitas kegiatan pembelajaran di Program Studi D4 - SIB</li>
                            <li>Meningkatnya kualitas hasil kegiatan kemahasiswaan D4 - SIB dan inisiasi pembinaan karier untuk pembekalan lulusan.</li>
                            <li>Meningkatnya relevansi, kuantitas, kualitas, dan kemanfaatan hasil penelitian seluruh sivitas akademika.</li>
                            <li>Meningkatnya relevansi, kuantitas, kualitas, dan kemanfaatan hasil pengabdian kepada masyarakat untuk kesejahteraan masyarakat.</li>
                        </ol>

                        <!-- Tombol Kembali -->
                        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-4">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
