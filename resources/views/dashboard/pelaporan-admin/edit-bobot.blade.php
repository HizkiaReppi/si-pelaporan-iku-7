<x-dashboard-layout title="Edit Bobot Mata Kuliah">
    <x-slot name="header">
        Edit Bobot Mata Kuliah
    </x-slot>

    <div class="card p-4">
        <form class="row" method="post" action="{{ route('dashboard.pelaporan-prodi.update-bobot', $pelaporan->id) }}">
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
            <div class="mb-3 col-md-6">
                <label class="form-label" for="bobot_case_method">Bobot Case Method <span style="font-size:14px;color:red">*</span></label>
                <input type="number" class="form-control {{ $errors->get('bobot_case_method') ? 'border-danger' : '' }}" id="bobot_case_method" name="bobot_case_method" placeholder="Bobot Case Method" value="{{ old('bobot_case_method', $pelaporan->score_case_method) }}" autocomplete="bobot_case_method" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_case_method')" />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="bobot_project_based">Bobot Project Based <span style="font-size:14px;color:red">*</span></label>
                <input type="number" class="form-control {{ $errors->get('bobot_project_based') ? 'border-danger' : '' }}" id="bobot_project_based" name="bobot_project_based" placeholder="Bobot Project Based" value="{{ old('bobot_project_based', $pelaporan->score_project_based) }}" autocomplete="bobot_project_based" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_project_based')" />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="bobot_kognitif_tugas">Bobot Kognitif Tugas <span style="font-size:14px;color:red">*</span></label>
                <input type="number" class="form-control {{ $errors->get('bobot_kognitif_tugas') ? 'border-danger' : '' }}" id="bobot_kognitif_tugas" name="bobot_kognitif_tugas" placeholder="Bobot Kognitif Tugas" value="{{ old('bobot_kognitif_tugas', $pelaporan->score_cognitive_task) }}" autocomplete="bobot_kognitif_tugas" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_kognitif_tugas')" />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="bobot_kognitif_kuis">Bobot Kognitif Kuis <span style="font-size:14px;color:red">*</span></label>
                <input type="number" class="form-control {{ $errors->get('bobot_kognitif_kuis') ? 'border-danger' : '' }}" id="bobot_kognitif_kuis" name="bobot_kognitif_kuis" placeholder="Bobot Kognitif Kuis" value="{{ old('bobot_kognitif_kuis', $pelaporan->score_cognitive_quiz) }}" autocomplete="bobot_kognitif_kuis" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_kognitif_kuis')" />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="bobot_kognitif_uts">Bobot Kognitif UTS <span style="font-size:14px;color:red">*</span></label>
                <input type="number" class="form-control {{ $errors->get('bobot_kognitif_uts') ? 'border-danger' : '' }}" id="bobot_kognitif_uts" name="bobot_kognitif_uts" placeholder="Bobot Kognitif UTS" value="{{ old('bobot_kognitif_uts', $pelaporan->score_cognitive_uts) }}" autocomplete="bobot_kognitif_uts" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_kognitif_uts')" />
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="bobot_kognitif_uas">Bobot Kognitif UAS <span style="font-size:14px;color:red">*</span></label>
                <input type="number" class="form-control {{ $errors->get('bobot_kognitif_uas') ? 'border-danger' : '' }}" id="bobot_kognitif_uas" name="bobot_kognitif_uas" placeholder="Bobot Kognitif UAS" value="{{ old('bobot_kognitif_uas', $pelaporan->score_cognitive_uas) }}" autocomplete="bobot_kognitif_uas" autofocus required />
                <x-input-error class="mt-2" :messages="$errors->get('bobot_kognitif_uas')" />
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="{{ route('dashboard.pelaporan-prodi.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
            </div>
        </form>
    </div>
</x-dashboard-layout>