@extends('layouts.app')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid text-center">
            <h1 class="display-4 font-weight-bold">Tujuan D4 Sistem Informasi Bisnis</h1>
        </div>
    </div>
@endsection

@section('main-content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h3 class="font-weight-bold mb-3">Tujuan</h3>
                        <ol style="font-size: 1.5rem;">
                            <li>Menghasilkan lulusan bidang sistem informasi bisnis yang sesuai kebutuhan, beretika dan bermoral baik, berpengetahuan dan berketerampilan tinggi, siap bekerja dan/atau berwirausaha yang mampu bersaing dalam skala nasional dan global;</li>
                            <li>Menghasilkan penelitian terapan bidang sistem informasi bisnis yang berskala nasional dan internasional, meningkatkan efektivitas, efisiensi, dan produktivitas dalam dunia usaha dan industri, serta mengarah pada pencapaian Hak atas Kekayaan Intelektual (HaKI), perolehan paten, dan kesejahteraan masyarakat;</li>
                            <li>Menghasilkan pengabdian kepada masyarakat yang dilaksanakan melalui penerapan dan penyebarluasan ilmu pengetahuan dan teknologi serta pemberian layanan hasil secara profesional dalam bidang sistem informasi bisnis sehingga bermanfaat secara langsung dalam meningkatkan kesejahteraan masyarakat;</li>
                            <li>Menghasilkan sistem manajemen pendidikan bidang sistem informasi bisnis yang memenuhi prinsip-prinsip tata kelola yang baik;</li>
                            <li>Terwujudnya kerja sama yang saling menguntungkan dengan berbagai pihak baik di dalam maupun di luar negeri pada bidang sistem informasi bisnis untuk meningkatkan daya saing.</li>
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
