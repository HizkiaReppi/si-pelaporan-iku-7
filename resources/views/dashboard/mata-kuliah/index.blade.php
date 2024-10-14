<x-dashboard-layout title="Manajemen Mata Kuliah">
    <x-slot name="header">
        Manajemen Mata Kuliah
    </x-slot>

    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Daftar Mata Kuliah</h5>
            <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-primary me-4">Tambah Mata
                Kuliah</button>
        </div>
        <div class="table-responsive text-nowrap px-4 pb-4">
            <table class="table" id="table-mk">
                <thead>
                    <tr>
                        <th class="text-center">Program Studi</th>
                        <th class="text-center">Kode Mata Kuliah</th>
                        <th class="text-center">Nama Mata Kuliah</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0"></tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Program Studi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="tambah-prodi" method="post" action="{{ route('dashboard.mata-kuliah.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="department_id" class="form-label">Program Studi <span
                                    style="font-size:14px;color:red">*</span></label>
                            <x-select :options="$departments" key="name" placeholders="Pilih Program Studi"
                                id="department_id" name="department_id" required />
                            <x-input-error class="mt-2" :messages="$errors->get('department_id')" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode-mk">Kode Mata Kuliah <span
                                    style="font-size:14px;color:red">*</span></label>
                            <input type="text"
                                class="form-control {{ $errors->get('kode-mk') ? 'border-danger' : '' }}" id="kode-mk"
                                name="kode-mk" placeholder="Kode Mata Kuliah" value="{{ old('kode-mk') }}"
                                autocomplete="name" autofocus required />
                            <x-input-error class="mt-2" :messages="$errors->get('kode-mk')" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama-mk">Nama Mata Kuliah <span
                                    style="font-size:14px;color:red">*</span></label>
                            <input type="text"
                                class="form-control {{ $errors->get('nama-mk') ? 'border-danger' : '' }}" id="nama-mk"
                                name="nama-mk" placeholder="Nama Mata Kuliah" value="{{ old('nama-mk') }}"
                                autocomplete="name" autofocus required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama-mk')" />
                        </div>
                        <div class="mb-3">
                            <label for="period_id" class="form-label">Tahun Akademik <span
                                    style="font-size:14px;color:red">*</span></label>
                            <x-select :options="$periods" key="name" placeholders="Pilih Tahun Akademik" id="period_id"
                                name="period_id" required />
                            <x-input-error class="mt-2" :messages="$errors->get('period_id')" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" form="tambah-prodi">Tambah Data</button>
                </div>
            </div>
        </div>
    </div>

    <!--  Modal Edit Form -->
    <div class="modal fade" id="modal-edit-data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalEditDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEditDataLabel">Edit Data Program Studi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-prodi" method="post" action="">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="edit-department_id" class="form-label">Program Studi <span
                                    style="font-size:14px;color:red">*</span></label>
                            <x-select :options="$departments" key="name" placeholders="Pilih Program Studi"
                                id="edit-department_id" name="department_id" required />
                            <x-input-error class="mt-2" :messages="$errors->get('department_id')" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit-kode-mk">Kode Mata Kuliah <span
                                    style="font-size:14px;color:red">*</span></label>
                            <input type="text" class="form-control" id="edit-kode-mk" name="kode-mk"
                                placeholder="Kode Mata Kuliah" required />
                            <x-input-error class="mt-2" :messages="$errors->get('kode-mk')" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit-nama-mk">Nama Mata Kuliah <span
                                    style="font-size:14px;color:red">*</span></label>
                            <input type="text" class="form-control" id="edit-nama-mk" name="nama-mk"
                                placeholder="Nama Mata Kuliah" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama-mk')" />
                        </div>
                        <div class="mb-3">
                            <label for="edit-period_id" class="form-label">Tahun Akademik <span
                                    style="font-size:14px;color:red">*</span></label>
                            <x-select :options="$periods" key="name" placeholders="Pilih Tahun Akademik"
                                id="edit-period_id" name="period_id" required />
                            <x-input-error class="mt-2" :messages="$errors->get('period_id')" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" form="edit-prodi">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#table-mk').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dashboard.mata-kuliah.index') }}',
                columns: [{
                        data: 'prodi',
                        name: 'prodi',
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'name'
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

            @if ($errors->has('fullname', 'faculty_id'))
                $('#staticBackdrop').modal('show');
            @endif

            $('#table-mk').on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const code = $(this).data('kode');
                const prodi = $(this).data('prodi');

                $('#edit-id').val(id);
                $('#edit-nama-mk').val(name);
                $('#edit-kode-mk').val(code);
                $('#edit-department_id').val(prodi);

                let formAction = "{{ route('dashboard.mata-kuliah.update', ':id') }}";
                formAction = formAction.replace(':id', id);
                $('#edit-prodi').attr('action', formAction);

                $('#modal-edit-data').modal('show');
            });
        });
    </script>
</x-dashboard-layout>
