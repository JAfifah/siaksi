<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-navy elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('dist/img/JTI.png') }}" alt="AdminLTE Logo"
            class="brand-image" style="opacity: .8">
            <span class="brand-text fw-bold fs-4">SIAKSI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            @php
                $menus = [
                    (object) [
                        'title' => 'MENU UTAMA',
                    ],
                    (object) [
                        'icon' => 'fas fa-tachometer-alt',
                        'name' => 'Dashboard',
                        'link' => '/dashboard',
                        'childs' => [],
                    ],
                    (object) [
                        'icon' => 'fas fa-list',
                        'name' => 'Website Polinema',
                        'link' => 'https://www.polinema.ac.id',
                        'external' => true,
                        'childs' => [],
                    ],
                    (object) [
                        'icon' => 'fas fa-list',
                        'name' => 'Denah Gedung',
                        'link' => '/denah',
                        'childs' => [],
                    ],
                    (object) [
                        'icon' => 'fas fa-list',
                        'name' => 'Buat Dokumen',
                        'link' => '/template',
                        'childs' => [],
                    ],
                    (object) [
                        'title' => 'KRITERIA',
                    ],
                    (object) [
                        'icon' => 'fas fa-book',
                        'name' => 'Kriteria',
                        'childs' => [
                            (object) ['name' => 'Kriteria 1', 'link' => '/kriteria/1'],
                            (object) ['name' => 'Kriteria 2', 'link' => '/kriteria/2'],
                            (object) ['name' => 'Kriteria 3', 'link' => '/kriteria/3'],
                            (object) ['name' => 'Kriteria 4', 'link' => '/kriteria/4'],
                            (object) ['name' => 'Kriteria 5', 'link' => '/kriteria/5'],
                            (object) ['name' => 'Kriteria 6', 'link' => '/kriteria/6'],
                            (object) ['name' => 'Kriteria 7', 'link' => '/kriteria/7'],
                            (object) ['name' => 'Kriteria 8', 'link' => '/kriteria/8'],
                            (object) ['name' => 'Kriteria 9', 'link' => '/kriteria/9'],
                        ],
                    ],
                    // 👉 Tambahkan item finalisasi di bawah daftar kriteria
                    (object) [
                        'icon' => 'fas fa-check-circle',
                        'name' => 'Finalisasi',
                        'link' => '/finalisasi',
                        'childs' => [],
                    ],
                    (object) [
                        'title' => 'AKUN PENGGUNA',
                    ],
                    (object) [
                        'icon' => 'fas fa-user',
                        'name' => 'Profil Akun',
                        'link' => '/profil-akun',
                        'childs' => [],
                    ],
                ];
            @endphp

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @foreach ($menus as $menu)
                    @if (isset($menu->title))
                        <li class="nav-header">{{ $menu->title }}</li>
                        @continue
                    @endif

                    @if (isset($menu->is_superuser) && $menu->is_superuser && !Auth::user()->is_superuser)
                        @continue
                    @endif

                    @php
                        $hasActiveChild = false;
                        if (count($menu->childs)) {
                            foreach ($menu->childs as $child) {
                                if (Request::is(trim($child->link, '/') . '*')) {
                                    $hasActiveChild = true;
                                    break;
                                }
                            }
                        }
                    @endphp

                    <li class="nav-item @if ($hasActiveChild) menu-open @endif">
                        <a class="nav-link @if ((!count($menu->childs) && Request::is(trim($menu->link, '/') . '*')) || $hasActiveChild) active @endif"
                            href="{{ count($menu->childs) ? '#' : $menu->link }}"
                            @if(isset($menu->external) && $menu->external) target="_blank" rel="noopener" @endif>                            
                            <i class="nav-icon {{ $menu->icon }}"></i>
                            <p>{{ $menu->name }}</p>
                            @if (count($menu->childs))
                                <i class="right fas fa-angle-left"></i>
                            @endif
                        </a>
                        @if (count($menu->childs))
                            <ul class="nav nav-treeview"
                                style="{{ $hasActiveChild ? 'display: block;' : 'display: none;' }}">
                                @foreach ($menu->childs as $child)
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is(trim($child->link, '/') . '*') ? 'active' : '' }}"
                                            href="{{ $child->link }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ $child->name }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach

                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class="nav-link" id="logout-button">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

@push('scripts')
    <script>
        document.getElementById('logout-button').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('logout-form').submit();
        });
    </script>
@endpush
