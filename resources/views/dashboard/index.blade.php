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
            <div>
                <h5>Rekap Pelaporan IKU 7 per Fakultas</h5>
                <div id="facultyIKUChart"></div>
            </div>
        </div>
        <hr class="mt-4">
        <div class="row mt-4">
            <h5>Rekap Pengajuan IKU 7 per Program Studi</h5>

            <div class="mb-3">
                <label for="facultyIkuFilter" class="form-label">Pilih Fakultas</label>
                <select id="facultyIkuFilter" class="form-select">
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}">
                            {{ $faculty->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="departmentIKUChart"></div>
        </div>
    </div>

    <div class="card px-4 pt-4 pb-3 mb-4">
        <div class="row">
            <div class="col-md-6">
                <h5>Total Pengajuan Per Fakultas</h5>
                <div id="facultySubmissionChart"></div>
            </div>
            <div class="col-md-6">
                <h5>Tren Performa per Periode</5>
                    <div id="chart-score-trends" class="mt-4"></div>
            </div>
        </div>
        <hr class="mt-4">
        <div class="row mt-4">
            <div>
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
                    formatter: (val) => `${val}`
                },
                colors: ['#008FFB'],
            };

            const submissionFacultiesChart = new ApexCharts(document.querySelector("#facultySubmissionChart"),
                submissionOptions);
            submissionFacultiesChart.render();

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
                    formatter: (val) => `${val}`
                },
                colors: ['#00E396'],
            };

            const departmentSubmissionChart = new ApexCharts(document.querySelector("#departmentSubmissionChart"),
                departmentChartOptions);
            departmentSubmissionChart.render();

            const loadFacultyChartData = (facultyId) => {
                fetch(`{{ route('dashboard.getSubmissionsByDepartment') }}`, {
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

            loadFacultyChartData(document.getElementById('facultyFilter').value);

            document.getElementById('facultyFilter').addEventListener('change', (event) => {
                loadFacultyChartData(event.target.value);
            });

            const chartFacultyOptions = {
                chart: {
                    type: 'bar',
                    height: 1500,
                    stacked: false,
                },
                series: [{
                        name: 'Total Mata Kuliah',
                        data: []
                    },
                    {
                        name: 'Draft',
                        data: []
                    },
                    {
                        name: 'Proses Verifikasi',
                        data: []
                    },
                    {
                        name: 'Terverifikasi',
                        data: []
                    },
                    {
                        name: 'Revisi',
                        data: []
                    },
                ],
                xaxis: {
                    categories: [],
                },
                title: {
                    text: 'Rekap Pengajuan IKU 7 per Fakultas',
                    align: 'center',
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val) => `${val}`,
                },
                colors: ['#007BFF', '#6C757D', '#FFA500', '#28A745', '#DC3545'],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        barHeight: '85%',
                    },
                },
                yaxis: { labels: { style: { padding: 20 } } },
            };

            const facultyChart = new ApexCharts(document.querySelector("#facultyIKUChart"), chartFacultyOptions);
            facultyChart.render();

            const loadChartData = () => {
                fetch(`{{ route('dashboard.getIKUDataByFaculty') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const facultyNames = Object.keys(data);
                        const prosesVerifikasiData = facultyNames.map(faculty => data[faculty]
                            .proses_verifikasi || 0);
                        const terverifikasiData = facultyNames.map(faculty => data[faculty].terverifikasi || 0);
                        const revisiData = facultyNames.map(faculty => data[faculty].revisi || 0);
                        const draftData = facultyNames.map(faculty => data[faculty].draft || 0);
                        const totalMataKuliahData = facultyNames.map(faculty => data[faculty]
                            .total_mata_kuliah || 0);

                        facultyChart.updateOptions({
                            series: [
                                {
                                    name: 'Total Mata Kuliah',
                                    data: totalMataKuliahData
                                },
                                {
                                    name: 'Draft',
                                    data: draftData
                                },
                                {
                                    name: 'Proses Verifikasi',
                                    data: prosesVerifikasiData
                                },
                                {
                                    name: 'Terverifikasi',
                                    data: terverifikasiData
                                },
                                {
                                    name: 'Revisi',
                                    data: revisiData
                                },
                            ],
                            xaxis: {
                                categories: facultyNames,
                            },
                        });
                    })
                    .catch(error => console.error('Error loading data:', error));
            };

            loadChartData();

            const ikuDepartmentChartOptions = {
                chart: {
                    type: 'bar',
                    height: 1500,
                    stacked: false,
                },
                series: [{
                        name: 'Total Mata Kuliah',
                        data: []
                    },
                    {
                        name: 'Draft',
                        data: []
                    },
                    {
                        name: 'Proses Verifikasi',
                        data: []
                    },
                    {
                        name: 'Terverifikasi',
                        data: []
                    },
                    {
                        name: 'Revisi',
                        data: []
                    },
                ],
                xaxis: {
                    categories: [],
                },
                title: {
                    text: 'Rekap Pengajuan IKU 7 per Program Studi',
                    align: 'center',
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val) => `${val}`,
                },
                colors: ['#007BFF', '#6C757D', '#FFA500', '#28A745', '#DC3545'],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        barHeight: '85%',
                    },
                },
                yaxis: { labels: { style: { padding: 20 } } },
            };

            const departmentChart = new ApexCharts(document.querySelector("#departmentIKUChart"),
                ikuDepartmentChartOptions);
            departmentChart.render();

            const loadIkuDepartmentChartData = (facultyId) => {
                fetch(`{{ route('dashboard.getIKUDataByDepartment') }}`, {
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
                        const departmentNames = Object.keys(data);
                        const prosesVerifikasiData = departmentNames.map(department => data[department]
                            .proses_verifikasi || 0);
                        const terverifikasiData = departmentNames.map(department => data[department]
                            .terverifikasi || 0);
                        const revisiData = departmentNames.map(department => data[department].revisi || 0);
                        const draftData = departmentNames.map(department => data[department].draft || 0);
                        const totalMataKuliahData = departmentNames.map(department => data[department]
                            .total_mata_kuliah || 0);

                        departmentChart.updateOptions({
                            series: [
                                {
                                    name: 'Total Mata Kuliah',
                                    data: totalMataKuliahData
                                },
                                {
                                    name: 'Draft',
                                    data: draftData
                                },
                                {
                                    name: 'Proses Verifikasi',
                                    data: prosesVerifikasiData
                                },
                                {
                                    name: 'Terverifikasi',
                                    data: terverifikasiData
                                },
                                {
                                    name: 'Revisi',
                                    data: revisiData
                                },
                            ],
                            xaxis: {
                                categories: departmentNames,
                            },
                        });
                    })
                    .catch(error => console.error('Error loading data:', error));
            };

            loadIkuDepartmentChartData(document.getElementById('facultyIkuFilter').value);

            document.getElementById('facultyIkuFilter').addEventListener('change', (event) => {
                loadIkuDepartmentChartData(event.target.value);
            });
        })
    </script>
</x-dashboard-layout>
