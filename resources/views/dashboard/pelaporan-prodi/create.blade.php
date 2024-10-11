<x-dashboard-layout title="Tambah Mata Kuliah">
    <x-slot name="header">
        Tambah Mata Kuliah
    </x-slot>

    <div class="card p-4">
        <form class="row" method="post" action="{{ route('dashboard.pelaporan-prodi.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3 col-md-6">
                <label class="form-label" for="kode_mk">Kode Mata Kuliah <span style="font-size:14px;color:red">*</span></label>
                <input type="text" class="form-control {{ $errors->get('kode_mk') ? 'border-danger' : '' }}" id="kode_mk" name="kode_mk" placeholder="Kode Mata Kuliah" value="{{ old('kode_mk') }}" autocomplete="kode_mk" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('kode_mk')" />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="nama_mk">Nama Mata Kuliah <span style="font-size:14px;color:red">*</span></label>
                <input type="text" class="form-control {{ $errors->get('nama_mk') ? 'border-danger' : '' }}" id="nama_mk" name="nama_mk" placeholder="Nama Mata Kuliah" value="{{ old('nama_mk') }}" autocomplete="nama_mk" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('nama_mk')" />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="bobot_case_method">Bobot Case Method <span style="font-size:14px;color:red">*</span></label>
                <input type="number" class="form-control {{ $errors->get('bobot_case_method') ? 'border-danger' : '' }}" id="bobot_case_method" name="bobot_case_method" placeholder="Bobot Case Method" value="{{ old('bobot_case_method') }}" autocomplete="bobot_case_method" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_case_method')" />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="bobot_project_based">Bobot Project Based <span style="font-size:14px;color:red">*</span></label>
                <input type="number" class="form-control {{ $errors->get('bobot_project_based') ? 'border-danger' : '' }}" id="bobot_project_based" name="bobot_project_based" placeholder="Bobot Project Based" value="{{ old('bobot_project_based') }}" autocomplete="bobot_project_based" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_project_based')" />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="bobot_kognitif_tugas">Bobot Kognitif Tugas <span style="font-size:14px;color:red">*</span></label>
                <input type="number" class="form-control {{ $errors->get('bobot_kognitif_tugas') ? 'border-danger' : '' }}" id="bobot_kognitif_tugas" name="bobot_kognitif_tugas" placeholder="Bobot Kognitif Tugas" value="{{ old('bobot_kognitif_tugas') }}" autocomplete="bobot_kognitif_tugas" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_kognitif_tugas')" />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="bobot_kognitif_kuis">Bobot Kognitif Kuis <span style="font-size:14px;color:red">*</span></label>
                <input type="number" class="form-control {{ $errors->get('bobot_kognitif_kuis') ? 'border-danger' : '' }}" id="bobot_kognitif_kuis" name="bobot_kognitif_kuis" placeholder="Bobot Kognitif Kuis" value="{{ old('bobot_kognitif_kuis') }}" autocomplete="bobot_kognitif_kuis" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_kognitif_kuis')" />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="bobot_kognitif_uts">Bobot Kognitif UTS <span style="font-size:14px;color:red">*</span></label>
                <input type="number" class="form-control {{ $errors->get('bobot_kognitif_uts') ? 'border-danger' : '' }}" id="bobot_kognitif_uts" name="bobot_kognitif_uts" placeholder="Bobot Kognitif UTS" value="{{ old('bobot_kognitif_uts') }}" autocomplete="bobot_kognitif_uts" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_kognitif_uts')" />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="bobot_kognitif_uas">Bobot Kognitif UAS <span style="font-size:14px;color:red">*</span></label>
                <input type="number" class="form-control {{ $errors->get('bobot_kognitif_uas') ? 'border-danger' : '' }}" id="bobot_kognitif_uas" name="bobot_kognitif_uas" placeholder="Bobot Kognitif UAS" value="{{ old('bobot_kognitif_uas') }}" autocomplete="bobot_kognitif_uas" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_kognitif_uas')" />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="file_rps">File RPS <span style="font-size:14px;color:red">*</span></label>
                <input type="file" class="form-control {{ $errors->has("file_rps") ? 'border-danger' : '' }}" id="file_rps" name="file_rps" accept="application/pdf" required>
                <x-input-error class="mt-2" :messages="$errors->get('file_rps')" />
            </div>
            <div class="mb-3 col-md-6">
                <label for="periode_id" class="form-label">Tahun Akademik <span
                        style="font-size:14px;color:red">*</span></label>
                <x-select :options="$periods" key="name" placeholders="Pilih Tahun Akademik" id="periode_id"
                    name="periode_id" required />
                <x-input-error class="mt-2" :messages="$errors->get('periode_id')" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="deskripsi_penilaian_case_method">Deskripsi Penilaian Case Method <span style="font-size:14px;color:red">*</span></label>
                <input id="deskripsi_penilaian_case_method" type="hidden" name="deskripsi_penilaian_case_method" value="{{ old('deskripsi_penilaian_case_method') }}">
                <trix-editor input="deskripsi_penilaian_case_method"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_case_method')" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="deskripsi_penilaian_project_based">Deskripsi Penilaian Project Based <span style="font-size:14px;color:red">*</span></label>
                <input id="deskripsi_penilaian_project_based" type="hidden" name="deskripsi_penilaian_project_based" value="{{ old('deskripsi_penilaian_project_based') }}">
                <trix-editor input="deskripsi_penilaian_project_based"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_project_based')" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="deskripsi_penilaian_kognitif_tugas">Deskripsi Penilaian Kognitif Tugas <span style="font-size:14px;color:red">*</span></label>
                <input id="deskripsi_penilaian_kognitif_tugas" type="hidden" name="deskripsi_penilaian_kognitif_tugas" value="{{ old('deskripsi_penilaian_kognitif_tugas') }}">
                <trix-editor input="deskripsi_penilaian_kognitif_tugas"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_kognitif_tugas')" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="deskripsi_penilaian_kognitif_kuis">Deskripsi Penilaian Kognitif Kuis <span style="font-size:14px;color:red">*</span></label>
                <input id="deskripsi_penilaian_kognitif_kuis" type="hidden" name="deskripsi_penilaian_kognitif_kuis" value="{{ old('deskripsi_penilaian_kognitif_kuis') }}">
                <trix-editor input="deskripsi_penilaian_kognitif_kuis"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_kognitif_kuis')" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="deskripsi_penilaian_kognitif_uts">Deskripsi Penilaian Kognitif UTS <span style="font-size:14px;color:red">*</span></label>
                <input id="deskripsi_penilaian_kognitif_uts" type="hidden" name="deskripsi_penilaian_kognitif_uts" value="{{ old('deskripsi_penilaian_kognitif_uts') }}">
                <trix-editor input="deskripsi_penilaian_kognitif_uts"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_kognitif_uts')" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="deskripsi_penilaian_kognitif_uas">Deskripsi Penilaian Kognitif UAS <span style="font-size:14px;color:red">*</span></label>
                <input id="deskripsi_penilaian_kognitif_uas" type="hidden" name="deskripsi_penilaian_kognitif_uas" value="{{ old('deskripsi_penilaian_kognitif_uas') }}">
                <trix-editor input="deskripsi_penilaian_kognitif_uas"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_kognitif_uas')" />
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Tambah Data</button>
                <a href="{{ route('dashboard.pelaporan-prodi.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('trix-file-accept', (event) => {
            event.preventDefault();
        })
    </script>
</x-dashboard-layout>