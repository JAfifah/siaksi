@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid text-center">
            <h1 class="display-4 font-weight-bold">VISI D4 Sistem Informasi Bisnis</h1>
        </div>
    </div>
@endsection

@section('main-content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-15">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h3 class="font-weight-bold mb-3">VISI</h3>
                        <p style="font-size: 1.5rem;">
                            Menjadi Program Studi yang Unggul dalam Bidang Sistem informasi bisnis Baik di Tingkat Nasional Maupun Internasional
                        </p>
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
