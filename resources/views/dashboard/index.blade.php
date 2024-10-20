<x-dashboard-layout title="Dashboard">
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="card px-4 pt-4 pb-3 mb-4">
        <div class="row">
            <div class="col-md-3 col-6 mb-2">
                <div class="card p-1">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="menu-icon tf-icons fa-solid fa-chalkboard-user"></i>
                                <span class="fw-medium d-block mb-1">Total Akun Prodi</span>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="{{ route('dashboard.admin-prodi.index') }}">Lihat
                                        Detail</a>
                                </div>
                            </div>
                        </div>
                        <h3 class="card-title mb-0 mt-3">{{ $totalDepartmentsWithAccounts }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="card p-1">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="menu-icon tf-icons fa-solid fa-rectangle-list"></i>
                                <span class="fw-medium d-block mb-1">Total Mata Kuliah</span>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="{{ route('dashboard.mata-kuliah.index') }}">Lihat
                                        Detail</a>
                                </div>
                            </div>
                        </div>
                        <h3 class="card-title mb-0 mt-3">{{ $totalCourses }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="card p-1">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="menu-icon tf-icons fa-solid fa-list-check"></i>
                                <span class="fw-medium d-block mb-1">Total Mata Kuliah Yang Telah Dilaporkan</span>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="{{ route('dashboard.pelaporan-admin.index') }}">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        <h3 class="card-title mb-0 mt-3">{{ $totalCoursesReported }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="card p-1">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="menu-icon tf-icons fa-solid fa-list"></i>
                                <span class="fw-medium d-block mb-1">Total Mata Kuliah Yang Belum Dilaporkan</span>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="{{ route('dashboard.pelaporan-admin.index') }}">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        <h3 class="card-title mb-0 mt-3">{{ $totalCoursesNotReported }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>