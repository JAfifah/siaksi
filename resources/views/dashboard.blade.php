@extends('layouts.app')

@section('content-header')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 text-center">
                    <h2 class="display-3 font-weight-bold">Selamat Datang</h2>
                    <h2 class="display-5 font-weight-bold">Di Akreditasi D4 Sistem Informasi Bisnis Jurusan Teknologi Informasi<br>
                        Politeknik Negeri Malang</h2>

                </div>
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>VISI</h3>

                    <p>D4 SIB</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('beranda.visi') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>                
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>MISI</h3>

                    <p>D4 SIB</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('beranda.misi') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>TUJUAN</h3>

                    <p>D4 SIB</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document-text"></i>
                </div>
                <a href="{{ route('beranda.tujuan') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
                
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>SASARAN</h3>

                    <p>D4 SIB</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <a href="{{ route('beranda.sasaran') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>                
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
@endsection
