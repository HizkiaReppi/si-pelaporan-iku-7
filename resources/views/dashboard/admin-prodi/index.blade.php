<x-dashboard-layout title="Manajemen Admin Program Studi">
    <x-slot name="header">
        Manajemen Admin Program Studi
    </x-slot>

    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Daftar Admin Program Studi</h5>
            <a href="{{ route('dashboard.admin-prodi.create') }}" class="btn btn-primary me-4">Tambah Admin Program Studi</a>
        </div>
        <div class="table-responsive text-nowrap px-4 pb-4">
            <table class="table" id="table-prodi">
                <thead>
                    <tr>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Fakultas</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0"></tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#table-prodi').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dashboard.admin-prodi.index') }}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'fakultas',
                        name: 'fakultas',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
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
