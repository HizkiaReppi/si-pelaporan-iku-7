@php
    $baseUrl = config('app.url');

    $baseUrl = explode('://', $baseUrl)[1];

    if (request()->secure()) {
        $baseUrl = 'https://' . $baseUrl;
    } else {
        $baseUrl = 'http://' . $baseUrl;
    }
@endphp

<x-error-layout title="Coming Soon">
    <div class="mb-0">
        <img src="{{$baseUrl}}/assets/images/maintenance.svg" alt="Maintenance" width="500" class="img-fluid" />
    </div>
    <h1 class="mb-2 mx-2">Coming Soon :(</h1>
    <h5 class="mb-4 mx-2">Fitur sedang dalam pengembangan.</h5>

    <button type="button" id="back" class="btn btn-primary">Kembali ke Halaman Sebelumnya</button>

    <script>
        document.getElementById('back').addEventListener('click', function() {
            window.history.back();
        });

        setTimeout(() => {
            window.history.back();
        }, 20000);
    </script>
</x-error-layout>
