@php
    $badgeColor = match ($user->status) {
        'pending' => '#007BFF', // Blue (Default)
        'approved' => '#28A745', // Green
        'rejected' => '#DC3545', // Red
        default => '#343A40', // Dark Grey (for any undefined status)
    };

    $statusName = match ($user->status) {
        'pending' => 'Menunggu Verifikasi',
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak',
        default => 'Undefined',
    };

    $badgeTextColor = match ($user->status) {
        'pending' => '#FFFFFF', // White (suitable for blue background)
        'approved' => '#FFFFFF', // White (suitable for green background)
        'rejected' => '#FFFFFF', // White (suitable for red background)
        default => '#FFFFFF', // White (default for any undefined status)
    };

@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Status Pengajuan Akun Anda Telah Diperbarui</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        p {
            font-size: 14px;
            margin-bottom: 15px;
        }

        .badge {
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 12px;
            display: inline-block;
        }

        .label-note {
            margin-bottom: 5px;
        }

        .note {
            background-color: #f9f9f9;
            border-left: 5px solid #ff9800;
            padding: 5px 10px;
            border-radius: 5px;
        }

        a.btn {
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }

        a.btn:hover {
            background-color: #45a049;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>Yth. <strong>{{ $user->name }}</strong>,</p>

        <p>
            Kami harap Anda selalu dalam kondisi yang sehat dan sejahtera. Kami ingin menginformasikan bahwa pengajuan
            akun Anda
            dengan email Program Studi <strong>{{ $user->email }}</strong> telah <strong>diperbarui</strong> oleh tim
            kami.
        </p>

        <p>
            Status terbaru pengajuan Anda saat ini adalah sebagai berikut:
        </p>

        <div style="margin: 15px 0;">
            <span class="badge"
                style="background-color: {{ $badgeColor }}; color: {{ $badgeTextColor }}; padding: 10px 15px; border-radius: 5px; font-size: 14px;">
                {{ $statusName }}
            </span>
        </div>

        <p>
            Kami menyarankan Anda untuk segera masuk ke Sistem Informasi untuk melihat detail lebih lanjut terkait
            status akun Anda. Dan anda dapat melakukan pelaporan mata kuliah beserta mengunggah RPS mata kuliah di menu
            yang telah disediakan. Anda dapat melakukan login dengan menggunakan email dan password yang telah Anda
            daftarkan sebelumnya.
        </p>

        <div style="text-align: center; margin: 20px 0;">
            <a class="btn" href="{{ route('login') }}"
                style="background-color: #007BFF; color: #ffffff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">
                Login Ke Sistem Informasi
            </a>
        </div>

        <p>
            Jika ada pertanyaan atau butuh bantuan lebih lanjut, jangan ragu untuk menghubungi tim dukungan kami.
        </p>

        <p>Terima kasih atas perhatian Anda.</p>

        <div class="footer" style="margin-top: 20px; color: #777;">
            <p>Hormat Kami,</p>
            <p><strong>Tim Admin Sistem Informasi Pelaporan IKU7 UNIMA</strong></p>
        </div>
    </div>

</body>

</html>
