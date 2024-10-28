@php
    $homeLink = null;

    if (auth()->user()->role == 'admin' || auth()->user()->role == 'super-admin') {
        $homeLink = route('dashboard');
    } elseif (auth()->user()->role == 'admin-prodi') {
        $homeLink = route('dashboard.pelaporan-prodi.index');
    }

    $baseUrl = config('app.url');

    $baseUrl = explode('://', $baseUrl)[1];

    if (request()->secure()) {
        $baseUrl = 'https://' . $baseUrl;
    } else {
        $baseUrl = 'http://' . $baseUrl;
    }
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ $homeLink }}" class="app-brand-link" style="margin-left:-10px">
            <img src="{{$baseUrl}}/assets/images/logo-unima.png" class="img-fluid" style="width: 50px" />
            <span class="app-brand-text demo menu-text fw-bold ms-2 text-uppercase">IKU7 UNIMA</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        @canany(['admin-prodi'])
        <li class="menu-item {{ request()->routeIs('dashboard-program-studi*') ? 'active' : '' }}">
                <a href="{{ route('dashboard-program-studi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-chart-line"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('dashboard.pelaporan-prodi.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-solid fa-clipboard-list"></i>
                    <div data-i18n="Bimbingan">Pelaporan IKU 7</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('dashboard.pelaporan-prodi.index') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.pelaporan-prodi.index') }}" class="menu-link">
                            <div data-i18n="Daftar Mata Kuliah">Daftar Mata Kuliah</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item {{ request()->routeIs('dashboard.kelas-mata-kuliah.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-solid fa-table-list"></i>
                    <div data-i18n="Bimbingan">Kelas Mata Kuliah</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('dashboard.kelas-mata-kuliah.index') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.kelas-mata-kuliah.index') }}" class="menu-link">
                            <div data-i18n="Daftar Mata Kuliah">Daftar Mata Kuliah</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('dashboard.kelas-mata-kuliah.daftar-nilai.index') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.kelas-mata-kuliah.daftar-nilai.index') }}" class="menu-link">
                            <div data-i18n="Daftar Mata Kuliah">Generate Daftar Nilai</div>
                        </a>
                    </li>
                </ul>
            </li>
        @elsecanany(['admin', 'super-admin'])
            <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-chart-line"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Manajemen Laporan IKU 7</span>
            </li>
            <li class="menu-item {{ request()->routeIs('dashboard.pelaporan-admin.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.pelaporan-admin.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-clipboard-list"></i>
                    <div data-i18n="Laporan IKU 7">Laporan IKU 7</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('dashboard.mata-kuliah.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.mata-kuliah.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-table-list"></i>
                    <div data-i18n="Daftar Mata Kuliah">Daftar Mata Kuliah</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('dashboard.periode.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.periode.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-calendar"></i>
                    <div data-i18n="Manajemen Periode">Manajemen Periode</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Manajemen Pengguna</span>
            </li>
            <li class="menu-item {{ request()->routeIs('dashboard.fakultas.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.fakultas.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-building"></i>
                    <div data-i18n="Fakultas">Fakultas</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('dashboard.prodi.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.prodi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-user"></i>
                    <div data-i18n="Program Studi">Program Studi</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('dashboard.admin-prodi.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.admin-prodi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-user-pen"></i>
                    <div data-i18n="Program Studi">Admin Program Studi</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('dashboard.administrator.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.administrator.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-user-gear"></i>
                    <div data-i18n="Admin">Administrator</div>
                </a>
            </li>
        </ul>
    @endcanany
</aside>
