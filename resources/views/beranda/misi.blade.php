@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid text-center">
            <h1 class="display-4 font-weight-bold">MISI D4 Sistem Informasi Bisnis</h1>
        </div>
    </div>
@endsection

@section('main-content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h3 class="font-weight-bold mb-3">MISI</h3>
                        <ol style="font-size: 1.5rem;">
                            <li>Melaksanakan pendidikan vokasi yang inovatif berdasarkan pada sistem pendidikan terapan dengan memanfaatkan kemajuan teknologi, sehingga mampu menghasilkan lulusan yang memiliki kompetensi di bidang sistem informasi bisnis dan siap bersaing di tingkat nasional dan global.</li>
                            <li>Menyelenggarakan penelitian terapan berbasis produk dan jasa bidang Sistem informasi bisnis.</li>
                            <li>Melaksanakan pengabdian masyarakat dengan menggunakan kemajuan bidang Sistem informasi bisnis untuk meningkatkan kesejahteraan.</li>
                            <li>Mewujudkan kerjasama yang saling menguntungkan dengan berbagai pihak baik didalam maupun diluar negeri pada bidang sistem informasi bisnis.</li>
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
