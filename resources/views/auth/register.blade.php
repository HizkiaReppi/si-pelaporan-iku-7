<x-auth-layout title="Register">
    <!-- Register -->
    <section class="d-flex justify-content-center align-items-center">
        <div class="card">
            <div class="card-body">
                <!-- Logo -->
                <div class="app-brand justify-content-center fs-2 mb-3">
                    <a href="/" class="app-brand-link">
                        SI PELAPORAN IKU 7
                    </a>
                </div>
                <h4 class="mb-3 fs-4 text-center">Selamat Datang di SI PELAPORAN IKU 7</h4>

                <form class="mb-3 mt-1" method="post" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="fullname">Nama Program Studi <span
                                style="font-size:14px;color:red">*</span></label>
                        <input type="text" class="form-control {{ $errors->get('fullname') ? 'border-danger' : '' }}"
                            id="fullname" name="fullname" placeholder="Nama Lengkap" value="{{ old('fullname') }}"
                            autocomplete="name" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('fullname')" />
                    </div>
                    <div class="mb-3">
                        <label for="faculty_id" class="form-label">Fakultas <span
                                style="font-size:14px;color:red">*</span></label>
                        <x-select :options="$faculties" key="name" placeholders="Pilih Fakultas" id="faculty_id"
                            name="faculty_id" required />
                        <x-input-error class="mt-2" :messages="$errors->get('faculty_id')" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email <span
                                style="font-size:14px;color:red">*</span></label>
                        <input type="email" class="form-control {{ $errors->get('email') ? 'border-danger' : '' }}"
                            id="email" name="email" placeholder="Email" value="{{ old('email') }}"
                            autocomplete="email" required />
                        <div id="form-email-help" class="form-text"></div>
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                    <div class="mb-3 form-password-toggle">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="******" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                    </div>
                    <div class="mb-3 form-password-toggle">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password_confirmation" class="form-control"
                                name="password_confirmation" placeholder="******" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                    </div>
                    <div class="mb-1">
                        <button class="btn btn-primary d-grid w-100" type="submit">Register</button>
                    </div>
                </form>
                <p class="text-center">
                    <span>Sudah memiliki akun?</span>
                    <a href="{{ route('login') }}">
                        <span>Masuk sekarang!</span>
                    </a>
                </p>
            </div>
        </div>
    </section>
</x-auth-layout>
