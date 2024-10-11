<x-dashboard-layout title="Manajemen Program Studi">
    <x-slot name="header">
        Manajemen Program Studi
    </x-slot>

    <div class="card mb-4">
        <h5 class="card-header">Detail Prorgam Studi</h5>
        <div class="card-body pb-2">
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="fullname" class="form-label">Nama Prorgam Studi</label>
                    <p class="border p-2 rounded m-0">{{ $program_studi->user->name }}</p>
                </div>
                <div class="mb-3 col-md-12">
                    <label for="fakultas" class="form-label">Fakultas</label>
                    <p class="border p-2 rounded m-0">{{ $program_studi->fakultas->name }}</p>
                </div>
                <div class="mb-3 col-md-12">
                    <label for="email" class="form-label">Email</label>
                    <p class="border p-2 rounded m-0">
                        <a
                            href="mailto:{{ $program_studi->user->email }}">{{ $program_studi->user->email }}</a>
                    </p>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Status Akun</label>
                    <p class="border p-2 rounded m-0">
                        <span class="badge bg-{{ \App\Helpers\StatusHelper::parseUserBadgeClassNameStatus($program_studi->user->status) }}">
                            {{ \App\Helpers\StatusHelper::parseUserStatus($program_studi->user->status) }}
                        </span>
                    </p>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Status Verifikasi Email</label>
                    <p class="border p-2 rounded m-0">
                        @if ($program_studi->user->hasVerifiedEmail())
                            <span class="badge text-bg-primary">Terverifikasi</span>
                        @else
                            <span class="badge text-bg-danger">Tidak Terverifikasi</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2 mb-4 ms-3" style="margin-top: -15px">
            <a href="{{ route('dashboard.prodi.index') }}" class="btn btn-outline-secondary ms-2">Kembali</a>
            @if ($program_studi->user->status == 'pending')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Tanggapi Status Akun
            </button>
            @endif
            <a class="btn btn-info" href="{{ route('dashboard.prodi.edit', $program_studi->id) }}">
                Edit Program Studi
            </a>
            <a class="btn btn-danger" href="{{ route('dashboard.prodi.destroy', $program_studi->id) }}"
                data-confirm-delete="true">
                Hapus Program Studi
            </a>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tanggapi Status Akun</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('dashboard.prodi.update-status', $program_studi->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label" for="status">Status</label>
                            <select id="status" name="status"
                                class="form-control {{ $errors->get('status') ? 'border-danger' : '' }}">
                                @php
                                    $statuses = [
                                        'pending' => 'Menunggu Persetujuan',
                                        'approved' => 'Setujui',
                                        'rejected' => 'Tolak',
                                    ]
                                @endphp
                                @foreach ($statuses as $status => $label)
                                    <option value="{{ $status }}"
                                        {{ old('status', $program_studi->user->status) == $status ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="submit">Simpan Respon</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>