<x-dashboard-layout title="Edit Bobot dan Deskripsi Mata Kuliah">
    <x-slot name="header">
        Edit Bobot dan Deskripsi Mata Kuliah
    </x-slot>

    <div class="card p-4">
        <form class="row" method="post" action="{{ route('dashboard.pelaporan-prodi.update', $pelaporan->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3 col-md-3">
                <label class="form-label" for="kode_mk">Kode Mata Kuliah</label>
                <p class="border p-2 rounded m-0">{{ $pelaporan->mataKuliah->code }}</p>
            </div>
            <div class="mb-3 col-md-9">
                <label class="form-label" for="nama_mk">Nama Mata Kuliah</label>
                <p class="border p-2 rounded m-0">{{ $pelaporan->mataKuliah->name }}</p>
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label" for="bobot_case_method">Bobot Case Method <span style="font-size:14px;color:red">*</span></label>
                <input type="number" max="100" min="0" class="form-control custom-input {{ $errors->get('bobot_case_method') ? 'border-danger' : '' }}" id="bobot_case_method" name="bobot_case_method" placeholder="Bobot Case Method" value="{{ old('bobot_case_method', $pelaporan->score_case_method) }}" autocomplete="bobot_case_method" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_case_method')" />
            </div>
            <div class="mb-3 col-md-9">
                <label class="form-label" for="deskripsi_penilaian_case_method">Deskripsi Penilaian Case Method</label>
                <input id="deskripsi_penilaian_case_method" type="hidden" name="deskripsi_penilaian_case_method"
                    value="{{ old('deskripsi_penilaian_case_method', $pelaporan->description_case_method) }}">
                <trix-editor input="deskripsi_penilaian_case_method"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_case_method')" />
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label" for="bobot_project_based">Bobot Project Based <span style="font-size:14px;color:red">*</span></label>
                <input type="number" max="100" min="0" class="form-control custom-input {{ $errors->get('bobot_project_based') ? 'border-danger' : '' }}" id="bobot_project_based" name="bobot_project_based" placeholder="Bobot Project Based" value="{{ old('bobot_project_based', $pelaporan->score_project_based) }}" autocomplete="bobot_project_based" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_project_based')" />
            </div>
            <div class="mb-3 col-md-9">
                <label class="form-label" for="deskripsi_penilaian_project_based">Deskripsi Penilaian Project Based</label>
                <input id="deskripsi_penilaian_project_based" type="hidden" name="deskripsi_penilaian_project_based"
                    value="{{ old('deskripsi_penilaian_project_based', $pelaporan->description_project_based) }}">
                <trix-editor input="deskripsi_penilaian_project_based"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_project_based')" />
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label" for="bobot_kognitif_tugas">Bobot Kognitif Tugas <span style="font-size:14px;color:red">*</span></label>
                <input type="number" max="100" min="0" class="form-control custom-input {{ $errors->get('bobot_kognitif_tugas') ? 'border-danger' : '' }}" id="bobot_kognitif_tugas" name="bobot_kognitif_tugas" placeholder="Bobot Kognitif Tugas" value="{{ old('bobot_kognitif_tugas', $pelaporan->score_cognitive_task) }}" autocomplete="bobot_kognitif_tugas" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_kognitif_tugas')" />
            </div>
            <div class="mb-3 col-md-9">
                <label class="form-label" for="deskripsi_penilaian_kognitif_tugas">Deskripsi Penilaian Kognitif Tugas</label>
                <input id="deskripsi_penilaian_kognitif_tugas" type="hidden" name="deskripsi_penilaian_kognitif_tugas"
                    value="{{ old('deskripsi_penilaian_kognitif_tugas', $pelaporan->description_cognitive_task) }}">
                <trix-editor input="deskripsi_penilaian_kognitif_tugas"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_kognitif_tugas')" />
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label" for="bobot_kognitif_kuis">Bobot Kognitif Kuis <span style="font-size:14px;color:red">*</span></label>
                <input type="number" max="100" min="0" class="form-control custom-input {{ $errors->get('bobot_kognitif_kuis') ? 'border-danger' : '' }}" id="bobot_kognitif_kuis" name="bobot_kognitif_kuis" placeholder="Bobot Kognitif Kuis" value="{{ old('bobot_kognitif_kuis', $pelaporan->score_cognitive_quiz) }}" autocomplete="bobot_kognitif_kuis" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_kognitif_kuis')" />
            </div>
            <div class="mb-3 col-md-9">
                <label class="form-label" for="deskripsi_penilaian_kognitif_kuis">Deskripsi Penilaian Kognitif Kuis</label>
                <input id="deskripsi_penilaian_kognitif_kuis" type="hidden" name="deskripsi_penilaian_kognitif_kuis"
                    value="{{ old('deskripsi_penilaian_kognitif_kuis', $pelaporan->description_cognitive_quiz) }}">
                <trix-editor input="deskripsi_penilaian_kognitif_kuis"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_kognitif_kuis')" />
            </div>
            <div class="mb-3 col-md-3">
                <label class="form-label" for="bobot_kognitif_uts">Bobot Kognitif UTS <span style="font-size:14px;color:red">*</span></label>
                <input type="number" max="100" min="0" class="form-control custom-input {{ $errors->get('bobot_kognitif_uts') ? 'border-danger' : '' }}" id="bobot_kognitif_uts" name="bobot_kognitif_uts" placeholder="Bobot Kognitif UTS" value="{{ old('bobot_kognitif_uts', $pelaporan->score_cognitive_uts) }}" autocomplete="bobot_kognitif_uts" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_kognitif_uts')" />
            </div>
            <div class="mb-3 col-md-9">
                <label class="form-label" for="deskripsi_penilaian_kognitif_uts">Deskripsi Penilaian Kognitif UTS</label>
                <input id="deskripsi_penilaian_kognitif_uts" type="hidden" name="deskripsi_penilaian_kognitif_uts"
                    value="{{ old('deskripsi_penilaian_kognitif_uts', $pelaporan->description_cognitive_uts) }}">
                <trix-editor input="deskripsi_penilaian_kognitif_uts"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_kognitif_uts')" />
            </div>
            <div class="col-md-3">
                <label class="form-label" for="bobot_kognitif_uas">Bobot Kognitif UAS <span style="font-size:14px;color:red">*</span></label>
                <input type="number" max="100" min="0" class="form-control custom-input {{ $errors->get('bobot_kognitif_uas') ? 'border-danger' : '' }}" id="bobot_kognitif_uas" name="bobot_kognitif_uas" placeholder="Bobot Kognitif UAS" value="{{ old('bobot_kognitif_uas', $pelaporan->score_cognitive_uas) }}" autocomplete="bobot_kognitif_uas" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_kognitif_uas')" />
            </div>
            <div class="col-md-9">
                <label class="form-label" for="deskripsi_penilaian_kognitif_uas">Deskripsi Penilaian Kognitif UAS</label>
                <input id="deskripsi_penilaian_kognitif_uas" type="hidden" name="deskripsi_penilaian_kognitif_uas"
                    value="{{ old('deskripsi_penilaian_kognitif_uas', $pelaporan->description_cognitive_uas) }}">
                <trix-editor input="deskripsi_penilaian_kognitif_uas"></trix-editor>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_penilaian_kognitif_uas')" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="file_rps">File RPS <span
                        style="font-size:14px;color:red">*</span></label>
                <input type="file" class="form-control {{ $errors->has('file_rps') ? 'border-danger' : '' }}"
                    id="file_rps" name="file_rps" accept="application/pdf" required>
                <x-input-error class="mt-2" :messages="$errors->get('file_rps')" />
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Edit Data</button>
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