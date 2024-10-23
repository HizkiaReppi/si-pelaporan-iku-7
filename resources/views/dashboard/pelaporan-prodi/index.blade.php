<x-dashboard-layout title="Manajemen Pelaporan IKU 7">
    <x-slot name="header">
        Manajemen Pelaporan IKU 7
    </x-slot>

    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Daftar Pelaporan IKU 7</h5>
        </div>
        <div class="table-responsive text-nowrap px-4 pb-4">
            <table class="table" id="table-pelaporan">
                <thead>
                    <tr>
                        <th class="text-center">Kode Mata Kuliah</th>
                        <th class="text-center">Nama Mata Kuliah</th>
                        <th class="text-center">Tahun Akademik</th>
                        <th class="text-center">Status Verifikasi</th>
                        <th class="text-center">Deskripsi Verifikasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0"></tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#table-pelaporan').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dashboard.pelaporan-prodi.index') }}',
                columns: [{
                        data: 'kodeMk',
                        name: 'kodeMk',
                        className: 'text-center'
                    },
                    {
                        data: 'namaMk',
                        name: 'namaMk',
                    },
                    {
                        data: 'periode',
                        name: 'periode',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });
        });
    </script>
</x-dashboard-layout>
