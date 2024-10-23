<x-dashboard-layout title="Manajemen Pelaporan IKU 7">
    <x-slot name="header">
        Manajemen Pelaporan IKU 7
    </x-slot>

    <div class="card mb-4">
        <h5 class="card-header">Detail Mata Kuliah</h5>
        <div class="card-body pb-2">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="fullname" class="form-label">Nama Mata Kuliah</label>
                    <p class="border p-2 rounded m-0">{{ $pelaporan->mataKuliah->name }}</p>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="kode-mk" class="form-label">Kode Mata Kuliah</label>
                    <p class="border p-2 rounded m-0">{{ $pelaporan->mataKuliah->code }}</p>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="bobot-case-method" class="form-label">Bobot Case Method</label>
                    <p class="border p-2 rounded m-0">{{ $pelaporan->score_case_method ?? '-' }}</p>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="bobot-project-based" class="form-label">Bobot Project Based</label>
                    <p class="border p-2 rounded m-0">{{ $pelaporan->score_project_based ?? '-' }}</p>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="bobot-kognitif-tugas" class="form-label">Bobot Kognitif Tugas</label>
                    <p class="border p-2 rounded m-0">{{ $pelaporan->score_cognitive_task ?? '-' }}</p>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="bobot-kognitif-kuis" class="form-label">Bobot Kognitif Kuis</label>
                    <p class="border p-2 rounded m-0">{{ $pelaporan->score_cognitive_quiz ?? '-' }}</p>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="bobot-kognitif-uts" class="form-label">Bobot Kognitif UTS</label>
                    <p class="border p-2 rounded m-0">{{ $pelaporan->score_cognitive_uts ?? '-' }}</p>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="bobot-kognitif-uas" class="form-label">Bobot Kognitif UAS</label>
                    <p class="border p-2 rounded m-0">{{ $pelaporan->score_cognitive_uas ?? '-' }}</p>
                </div>
                <div class="mb-3">
                    <label for="deskripsi-penilaian-case-method" class="form-label">Deskripsi Penilaian Case
                        Method</label>
                    <div class="border p-2 rounded m-0">{!! $pelaporan->description_case_method ?? '-' !!}</div>
                </div>
                <div class="mb-3">
                    <label for="deskripsi-penilaian-project-based" class="form-label">Deskripsi Penilaian Project
                        Based</label>
                    <div class="border p-2 rounded m-0">{!! $pelaporan->description_project_based ?? '-' !!}</div>
                </div>
                <div class="mb-3">
                    <label for="deskripsi-penilaian-kognitif-tugas" class="form-label">Deskripsi Penilaian Kognitif
                        Tugas</label>
                    <div class="border p-2 rounded m-0">{!! $pelaporan->description_cognitive_task ?? '-' !!}</div>
                </div>
                <div class="mb-3">
                    <label for="deskripsi-penilaian-kognitif-kuis" class="form-label">Deskripsi Penilaian Kognitif
                        Kuis</label>
                    <div class="border p-2 rounded m-0">{!! $pelaporan->description_cognitive_quiz ?? '-' !!}</div>
                </div>
                <div class="mb-3">
                    <label for="deskripsi-penilaian-kognitif-uts" class="form-label">Deskripsi Penilaian Kognitif
                        UTS</label>
                    <div class="border p-2 rounded m-0">{!! $pelaporan->description_cognitive_uts ?? '-' !!}</div>
                </div>
                <div class="mb-3">
                    <label for="deskripsi-penilaian-kognitif-uas" class="form-label">Deskripsi Penilaian Kognitif
                        UAS</label>
                    <div class="border p-2 rounded m-0">{!! $pelaporan->description_cognitive_uas ?? '-' !!}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Status Verifikasi</label>
                    <p class="border p-2 rounded m-0">
                        <span
                            class="badge bg-{{ \App\Helpers\StatusHelper::parseUserBadgeClassNameStatus($pelaporan->status_verifikasi) }}">
                            {{ \App\Helpers\StatusHelper::parseUserStatus($pelaporan->status_verifikasi) }}
                        </span>
                    </p>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="file" class="form-label">File RPS</label>
                    @if ($pelaporan->file_rps)
                        <a href="{{ route('dashboard.pelaporan-prodi.view', $pelaporan->id) }}"
                            class="d-block btn btn-secondary">Lihat File</a>
                    @else
                        <button class="d-block btn btn-secondary" type="button" disabled>
                            Belum Ada File
                        </button>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="deskripsi-verifikasi" class="form-label">Deskripsi Verifikasi</label>
                    <div class="border p-2 rounded m-0">{!! $pelaporan->deskripsi_verifikasi ?? '-' !!}</div>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2 mb-4 ms-3" style="margin-top: -15px">
            <a href="{{ route('dashboard.pelaporan-prodi.index') }}" class="btn btn-outline-secondary ms-2">Kembali</a>
            @if ($pelaporan->status_verifikasi == 'draft')
                <a class="btn btn-info" href="{{ route('dashboard.pelaporan-prodi.edit-bobot', $pelaporan->id) }}">
                    Edit Bobot
                </a>
                @if (\App\Helpers\IKUHelper::scoresAreFilled($pelaporan))
                    <a class="btn btn-info"
                        href="{{ route('dashboard.pelaporan-prodi.edit-deskripsi', $pelaporan->id) }}">
                        Edit Deskripsi
                    </a>
                @endif
            @endif
        </div>
    </div>
</x-dashboard-layout>
