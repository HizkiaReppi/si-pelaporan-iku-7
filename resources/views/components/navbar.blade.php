<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item dropdown me-2">
                <select class="form-select form-select-sm" id="period-select">
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}" {{ $period->id == $currentPeriodId ? 'selected' : '' }}>
                            Periode {{ $period->name }}
                        </option>
                    @endforeach
                </select>
            </li>
            {{-- Notif --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle hide-arrow position-relative" href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                    @if (auth()->user()->role !== 'admin-prodi')
                        @if ($registrationsCount > 0)
                            <span class="translate-middle badge rounded-pill bg-danger"
                                style="position:absolute;top:10px;right:-10px;font-size:9.5px;">
                                {{ $registrationsCount }}
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        @endif
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end notif-dropdown" aria-labelledby="navbarDropdownNotif">
                    <h5 class="dropdown-header">Notifikasi</h6>
                        @if (auth()->user()->role !== 'admin-prodi')
                            @forelse($registrations as $registration)
                                <a class="dropdown-item inline-block {{ $loop->last ? '' : 'border-bottom' }}"
                                    style="font-size: 14px;white-space: normal;width:100%;"
                                    href="{{ route('dashboard.admin-prodi.show', $registration->id) }}">
                                    {{ $registration->name . ' ingin mengajukan membuat akun' }}
                                    <small class="text-muted"
                                        style="font-size: 10px">({{ $registration->created_at->diffForHumans() }})</small>
                                </a>
                            @empty
                                <a class="dropdown-item text-center" href="#">Tidak ada notifikasi</a>
                            @endforelse
                        @endif
                </div>
            </li>

            <!-- User -->
            <li class="ms-2 nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="https://eu.ui-avatars.com/api/?name={{ Auth::user()->name }}&size=250"
                            class="w-px-40 h-auto rounded-circle" alt="{{ Auth::user()->name }}" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <div class="dropdown-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <div class="avatar avatar-online">
                                            <img src="https://eu.ui-avatars.com/api/?name={{ Auth::user()->name }}&size=250"
                                                class="w-px-40 h-auto rounded-circle" alt="{{ Auth::user()->name }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-medium d-block">{{ auth()->user()->name }}</span>
                                    @if (auth()->user()->role == 'admin-prodi')
                                        <small class="text-muted">Admin Program Studi</small>
                                    @else
                                        <small class="text-muted text-capitalize">{{ auth()->user()->role }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">Profil Saya</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form class="dropdown-item" method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="btn p-0">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>

<script>
    document.getElementById('period-select').addEventListener('change', function() {
        this.disabled = true;

        let selectedPeriodId = this.value;

        let routeLink = `{{ route('update-period', ":id") }}`;
        routeLink = routeLink.replace(':id', selectedPeriodId);

        fetch(routeLink, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                period_id: selectedPeriodId
            })
        }).then(() => {
            window.location.reload();
        }).catch((error) => {
            console.error('Error updating period:', error);
            this.disabled = false;
        });
    });
</script>