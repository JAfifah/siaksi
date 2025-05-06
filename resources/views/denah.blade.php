@extends('layouts.app')

@section('main-content')
    <div class="container-fluid">
        <h4 class="mb-4">Denah Ruang Gedung</h4>

        <div class="row">
            {{-- Card Lantai 5 --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Lantai 5</h3>
                        <p>Gedung Utama</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="https://my.matterport.com/show/?m=xufa7UrDLJe" class="small-box-footer" target="_blank">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Card Lantai 6 --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Lantai 6</h3>
                        <p>Gedung Utama</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="https://my.matterport.com/show/?m=Fj8fbnjLjQq" class="small-box-footer" target="_blank">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Card Lantai 7 --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>Lantai 7</h3>
                        <p>Gedung Utama</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="https://my.matterport.com/show/?m=fAgiViGeZaB" class="small-box-footer" target="_blank">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection
