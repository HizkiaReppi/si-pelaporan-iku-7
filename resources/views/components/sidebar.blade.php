@php
    $homeLink = null;

    if (auth()->user()->role == 'admin' || auth()->user()->role == 'super-admin') {
        $homeLink = route('dashboard');
    } elseif (auth()->user()->role == 'admin-prodi') {
        $homeLink = route('dashboard.pelaporan-prodi.index');
    }
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ $homeLink }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-2 text-uppercase">IKU7 UNIMA</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        @canany(['admin-prodi'])
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
                    <li class="menu-item {{ request()->routeIs('dashboard.pelaporan-prodi.edit-bobot') ? 'active' : '' }}">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-bobot"
                            class="menu-link">
                            <div data-i18n="Input Bobot Mata Kuliah">Input Bobot Mata Kuliah</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ request()->routeIs('dashboard.pelaporan-prodi.edit-deskripsi') ? 'active' : '' }}">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-deskripsi"
                            class="menu-link">
                            <div data-i18n="Input Deskripsi Mata Kuliah">Input Deskripsi Mata Kuliah</div>
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

@can('admin-prodi')
    <!-- Modal Deskripsi -->
    <div class="modal fade" id="modal-deskripsi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="1"
        aria-labelledby="modalEditDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEditDataLabel">Input Deskripsi Mata Kuliah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <form id="input-deskripsi" method="post"
                            action="{{ route('dashboard.pelaporan-prodi.input-deskripsi', '') }}">
                            @csrf
                            <label class="form-label" for="course_id">Mata Kuliah <span
                                    style="font-size:14px;color:red">*</span></label>
                            <x-select :options="$courses" key="name" placeholders="Pilih Mata Kuliah" id="course_deskripsi"
                                name="course_id" required />
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" form="input-deskripsi">Pilih Mata Kuliah Ini</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Bobot -->
    <div class="modal fade" id="modal-bobot" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEditDataLabel">Input Bobot Mata Kuliah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <form id="input-bobot" method="post"
                            action="{{ route('dashboard.pelaporan-prodi.input-bobot', '') }}">
                            @csrf
                            <label class="form-label" for="course_id">Mata Kuliah <span
                                    style="font-size:14px;color:red">*</span></label>
                            <x-select :options="$courses" key="name" placeholders="Pilih Mata Kuliah" id="course_bobot"
                                name="course_id" required />
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" form="input-bobot">Pilih Mata Kuliah Ini</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#course_deskripsi').on('change', function() {
                let courseId = $(this).val()
                let formAction = "{{ route('dashboard.pelaporan-prodi.input-deskripsi', ':id') }}";
                formAction = formAction.replace(':id', courseId);
                console.log(formAction);
                $('#input-deskripsi').attr('action', formAction);
            });

            $('#course_bobot').on('change', function() {
                let courseId = $(this).val();
                let formAction = "{{ route('dashboard.pelaporan-prodi.input-bobot', ':id') }}";
                formAction = formAction.replace(':id', courseId);
                $('#input-bobot').attr('action', formAction);
            });
        });
    </script>
@endcan
