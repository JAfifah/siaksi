@extends('layouts.app')

@push('styles')
<style>
.gradient-custom {
    background: linear-gradient(45deg, #1e88e5, #00acc1);
}
.stat-card {
    border: none;
    border-radius: 15px;
    transition: transform 0.3s ease;    
}
.stat-card:hover {
    transform: translateY(-5px);
}
.welcome-section {
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset("img/bgpolinema.jpg") }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    color: white;
    padding: 100px 0;
    margin-bottom: 40px;
    border-radius: 20px;
}
.info-box {
    box-shadow: 0 0 30px rgba(0,0,0,0.1);
    border-radius: 15px;
    overflow: hidden;
}
.quick-stats .icon {
    font-size: 40px;
    opacity: 0.7;
}
</style>
@endpush

@section('content-header')
<div class="welcome-section text-center">
    <h1 class="display-3 mb-4 font-weight-bold text-white">Selamat Datang di Polinema</h1>
    <h3 class="text-white mb-4">Sistem Informasi Akreditasi D4 Sistem Informasi Bisnis</h3>
    <p class="lead text-white">Politeknik Negeri Malang</p>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
    <!-- Quick Stats -->
    <div class="row quick-stats">
        <div class="col-lg-3 col-6">
            <div class="info-box mb-3 stat-card bg-info">
                <span class="info-box-icon"><i class="fas fa-star icon"></i></span>
                <div class="info-box-content">
                    <h5 class="text-white">VISI</h5>
                    <p class="mb-0">D4 SIB</p>
                    <a href="{{ route('beranda.visi') }}" class="text-white">
                        Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="info-box mb-3 stat-card bg-success">
                <span class="info-box-icon"><i class="fas fa-tasks icon"></i></span>
                <div class="info-box-content">
                    <h5 class="text-white">MISI</h5>
                    <p class="mb-0">D4 SIB</p>
                    <a href="{{ route('beranda.misi') }}" class="text-white">
                        Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="info-box mb-3 stat-card bg-warning">
                <span class="info-box-icon"><i class="fas fa-bullseye icon"></i></span>
                <div class="info-box-content">
                    <h5 class="text-white">TUJUAN</h5>
                    <p class="mb-0">D4 SIB</p>
                    <a href="{{ route('beranda.tujuan') }}" class="text-white">
                        Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="info-box mb-3 stat-card bg-danger">
                <span class="info-box-icon"><i class="fas fa-flag icon"></i></span>
                <div class="info-box-content">
                    <h5 class="text-white">SASARAN</h5>
                    <p class="mb-0">D4 SIB</p>
                    <a href="{{ route('beranda.sasaran') }}" class="text-white">
                        Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Denah Gedung</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-building fa-3x mb-3 text-info"></i>
                                    <h5>Lantai 5</h5>
                                    <a href="https://my.matterport.com/show/?m=xufa7UrDLJe" class="btn btn-info btn-sm mt-2" target="_blank">
                                        Lihat Denah
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-building fa-3x mb-3 text-success"></i>
                                    <h5>Lantai 6</h5>
                                    <a href="https://my.matterport.com/show/?m=Fj8fbnjLjQq" class="btn btn-success btn-sm mt-2" target="_blank">
                                        Lihat Denah
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-building fa-3x mb-3 text-warning"></i>
                                    <h5>Lantai 7</h5>
                                    <a href="https://my.matterport.com/show/?m=fAgiViGeZaB" class="btn btn-warning btn-sm mt-2" target="_blank">
                                        Lihat Denah
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<div class="col-lg-4">
    <div class="card">
        <div class="card-header border-0 d-flex align-items-center">
            <h3 class="card-title">
                <i class="fas fa-bell mr-2"></i>Aktivitas Terbaru
            </h3>
            <span class="badge badge-primary ml-auto">{{ $activities->count() }}</span>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse($activities as $activity)
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">
                                <i class="fas fa-user-circle mr-1"></i>
                                {{ $activity->user->name }}
                            </h6>
                            <small class="text-muted">
                                {{ $activity->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <p class="mb-1">{{ $activity->description }}</p>
                        <small>
                            <i class="fas fa-file-alt mr-1"></i>
                            {{ $activity->document->title ?? 'Dokumen' }}
                        </small>
                    </div>
                @empty
                    <div class="list-group-item text-center text-muted">
                        Belum ada aktivitas terbaru
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Add smooth scrolling
    $('.stat-card').hover(
        function() { $(this).addClass('shadow-lg'); },
        function() { $(this).removeClass('shadow-lg'); }
    );
});
</script>
@endpush