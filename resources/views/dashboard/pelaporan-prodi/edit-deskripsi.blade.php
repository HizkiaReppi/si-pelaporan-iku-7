<x-dashboard-layout title="Edit Deskripsi Mata Kuliah">
    <x-slot name="header">
        Edit Deskripsi Mata Kuliah
    </x-slot>

    <div class="card p-4">
        <form class="row" method="post" action="{{ route('dashboard.pelaporan-prodi.update-deskripsi', $pelaporan->id) }}">
            @csrf
            @method('put')

            <div class="mb-3 col-md-6">
                <label class="form-label" for="kode_mk">Kode Mata Kuliah</label>
                <p class="border p-2 rounded m-0">{{ $pelaporan->mataKuliah->code }}</p>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="nama_mk">Nama Mata Kuliah</label>
                <p class="border p-2 rounded m-0">{{ $pelaporan->mataKuliah->name }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label" for="deskripsi_penilaian_case_method">Deskripsi Penilaian Case Method <span
                        style="font-size:14px;color:red">*</span></label>
                <input id="deskripsi_penilaian_case_method" type="hidden" name="deskripsi_penilaian_case_method"
                    value="{{ old('deskripsi_penilaian_case_method', $pelaporan->description_case_method) }}">
                <trix-editor input="deskripsi_penilaian_case_method"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_case_method')" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="deskripsi_penilaian_project_based">Deskripsi Penilaian Project Based
                    <span style="font-size:14px;color:red">*</span></label>
                <input id="deskripsi_penilaian_project_based" type="hidden" name="deskripsi_penilaian_project_based"
                    value="{{ old('deskripsi_penilaian_project_based', $pelaporan->description_project_based) }}">
                <trix-editor input="deskripsi_penilaian_project_based"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_project_based')" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="deskripsi_penilaian_kognitif_tugas">Deskripsi Penilaian Kognitif Tugas
                    <span style="font-size:14px;color:red">*</span></label>
                <input id="deskripsi_penilaian_kognitif_tugas" type="hidden" name="deskripsi_penilaian_kognitif_tugas"
                    value="{{ old('deskripsi_penilaian_kognitif_tugas', $pelaporan->description_cognitive_task) }}">
                <trix-editor input="deskripsi_penilaian_kognitif_tugas"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_kognitif_tugas')" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="deskripsi_penilaian_kognitif_kuis">Deskripsi Penilaian Kognitif Kuis
                    <span style="font-size:14px;color:red">*</span></label>
                <input id="deskripsi_penilaian_kognitif_kuis" type="hidden" name="deskripsi_penilaian_kognitif_kuis"
                    value="{{ old('deskripsi_penilaian_kognitif_kuis', $pelaporan->description_cognitive_quiz) }}">
                <trix-editor input="deskripsi_penilaian_kognitif_kuis"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_kognitif_kuis')" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="deskripsi_penilaian_kognitif_uts">Deskripsi Penilaian Kognitif UTS <span
                        style="font-size:14px;color:red">*</span></label>
                <input id="deskripsi_penilaian_kognitif_uts" type="hidden" name="deskripsi_penilaian_kognitif_uts"
                    value="{{ old('deskripsi_penilaian_kognitif_uts', $pelaporan->description_cognitive_uts) }}">
                <trix-editor input="deskripsi_penilaian_kognitif_uts"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_kognitif_uts')" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="deskripsi_penilaian_kognitif_uas">Deskripsi Penilaian Kognitif UAS <span
                        style="font-size:14px;color:red">*</span></label>
                <input id="deskripsi_penilaian_kognitif_uas" type="hidden" name="deskripsi_penilaian_kognitif_uas"
                    value="{{ old('deskripsi_penilaian_kognitif_uas', $pelaporan->description_cognitive_uas) }}">
                <trix-editor input="deskripsi_penilaian_kognitif_uas"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_kognitif_uas')" />
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="{{ route('dashboard.pelaporan-prodi.index') }}"
                    class="btn btn-outline-secondary ms-2">Batal</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('trix-file-accept', (event) => {
            event.preventDefault();
        })
    </script>
</x-dashboard-layout>
