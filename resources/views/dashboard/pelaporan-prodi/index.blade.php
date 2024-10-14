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
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0"></tbody>
            </table>
        </div>
    </div>

    <!--  Modal Edit Form -->
    <div class="modal fade" id="modal-edit-rps" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalEditDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEditDataLabel">Edit RPS Mata Kuliah <span id="mata-kuliah"></span></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-rps" method="post" action="" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label class="form-label" for="file_rps">File RPS <span
                                    style="font-size:14px;color:red">*</span></label>
                            <input type="file"
                                class="form-control {{ $errors->has('file_rps') ? 'border-danger' : '' }}"
                                id="file_rps" name="file_rps" accept="application/pdf" required>
                            <x-input-error class="mt-2" :messages="$errors->get('file_rps')" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" form="edit-rps">Simpan RPS</button>
                </div>
            </div>
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });

            @if ($errors->has('file_rps'))
                $('#modal-edit-rps').modal('show');
            @endif

            $('#table-pelaporan').on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');

                $('#mata-kuliah').val(name);

                let formAction = "{{ route('dashboard.pelaporan-prodi.update-rps', ':id') }}";
                formAction = formAction.replace(':id', id);
                $('#edit-rps').attr('action', formAction);

                $('#modal-edit-rps').modal('show');
            });
        });
    </script>
</x-dashboard-layout>
