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
                                    <a class="dropdown-item" href="{{ route('dashboard.pelaporan-admin.index') }}">Lihat
                                        Detail</a>
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
                                    <a class="dropdown-item" href="{{ route('dashboard.pelaporan-admin.index') }}">Lihat
                                        Detail</a>
                                </div>
                            </div>
                        </div>
                        <h3 class="card-title mb-0 mt-3">{{ $totalCoursesNotReported }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card px-4 pt-4 pb-3 mb-4">
        <div class="row">
            <div class="col-md-6">
                <h5>Total Pengajuan Per Fakultas</h5>
                <div id="facultySubmissionChart"></div>
            </div>
            <div class="col-md-6">
                <h5>Total Pengajuan per Program Studi</h5>

                <div class="mb-3">
                    <label for="facultyFilter" class="form-label">Pilih Fakultas</label>
                    <select id="facultyFilter" class="form-select">
                        @foreach ($faculties as $faculty)
                            <option value="{{ $faculty->id }}">
                                {{ $faculty->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="departmentSubmissionChart"></div>
            </div>
        </div>
        <hr class="mt-4">
        <div class="row mt-4">
            <div class="col-md-6">
                <h5>Distribusi Status Verifikasi</h5>
                <div id="chart-verification-status"></div>
            </div>
            <div class="col-md-6">
                <h5>Tren Performa per Periode</5>
                    <div id="chart-score-trends" class="mt-4"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const submissionOptions = {
                series: [{
                    name: 'Total Pengajuan',
                    data: @json($submissionFacultiesData->values())
                }],
                chart: {
                    type: 'bar',
                    height: 400
                },
                xaxis: {
                    categories: @json($submissionFacultiesData->keys())
                },
                title: {
                    text: 'Total Pengajuan per Fakultas',
                    align: 'center'
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val) => `${val} pengajuan`
                },
                colors: ['#008FFB'],
            };

            const submissionFacultiesChart = new ApexCharts(document.querySelector("#facultySubmissionChart"),
                submissionOptions);
            submissionFacultiesChart.render();

            const verificationStatusOptions = {
                chart: {
                    type: 'pie'
                },
                series: [
                    {{ $verificationStatus->where('status_verifikasi', 'approved')->sum('total') }},
                    {{ $verificationStatus->where('status_verifikasi', 'pending')->sum('total') }},
                    {{ $verificationStatus->where('status_verifikasi', 'draft')->sum('total') }},
                ],
                labels: ['Disetujui', 'Menunggu Persetujuan', 'Draft'],
            };

            const verificationStatusChart = new ApexCharts(document.querySelector("#chart-verification-status"),
                verificationStatusOptions);
            verificationStatusChart.render();

            const scoreTrendsOptions = {
                chart: {
                    type: 'line'
                },
                series: [{
                    name: 'Average Score',
                    data: @json($scoreTrends->pluck('pelaporanIku.0.avg_score'))
                }],
                xaxis: {
                    categories: @json($scoreTrends->pluck('name'))
                },
                title: {
                    text: 'Tren Performa per Periode'
                }
            };

            const scoreTrendsChart = new ApexCharts(document.querySelector("#chart-score-trends"),
                scoreTrendsOptions);
            scoreTrendsChart.render();

            const departmentChartOptions = {
                series: [{
                    name: 'Total Pengajuan',
                    data: []
                }],
                chart: {
                    type: 'bar',
                    height: 400
                },
                xaxis: {
                    categories: []
                },
                title: {
                    text: 'Total Pengajuan per Program Studi',
                    align: 'center'
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val) => `${val} pengajuan`
                },
                colors: ['#00E396'],
            };

            const departmentSubmissionChart = new ApexCharts(document.querySelector("#departmentSubmissionChart"),
                departmentChartOptions);
            departmentSubmissionChart.render();

            const loadChartData = (facultyId) => {
                fetch(`/dashboard/submissions-by-department`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            faculty_id: facultyId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        departmentSubmissionChart.updateOptions({
                            series: [{
                                data: Object.values(data)
                            }],
                            xaxis: {
                                categories: Object.keys(data)
                            }
                        });
                    })
                    .catch(error => console.error('Error loading data:', error));
            };

            loadChartData(document.getElementById('facultyFilter').value);

            document.getElementById('facultyFilter').addEventListener('change', (event) => {
                loadChartData(event.target.value);
            });
        })
    </script>
</x-dashboard-layout>
