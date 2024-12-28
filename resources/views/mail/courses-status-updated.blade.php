<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Status Verifikasi Mata Kuliah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #212529;
        }

        p {
            text-align: justify;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 14px;
            text-align: center;
            font-size: 14px;
        }

        .content {
            padding: 20px;
        }

        .status {
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            font-size: 14px;
        }

        .status.pending {
            background-color: #ffeeba;
            color: #856404;
        }

        .status.approved {
            background-color: #d4edda;
            color: #155724;
        }

        .status.rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status.draft {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 5px;
            margin-top: 10px;
            font-weight: 600;
            text-align: center;
            font-size: 13px;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .footer {
            font-size: 12px;
            color: #868e96;
            padding: 15px;
            background-color: #f8f9fa;
        }

        .footer p {
            text-align: center;
        }

        .highlight {
            font-weight: bold;
            color: #007bff;
        }

        .note {
            font-style: italic;
            color: #6c757d;
            margin-top: 10px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <header class="header">
            <h1>Status Verifikasi Mata Kuliah Diperbarui</h1>
        </header>

        <!-- Content -->
        <main class="content">
            <p>Yth. Bapak/Ibu Admin Program Studi</p>
            <p style="margin-top: -10px"><strong>{{ $daftarPelaporan->prodi->name }}</strong></p>
            <hr>
            <p>Kami ingin menginformasikan bahwa status verifikasi laporan mata kuliah berikut telah diperbarui:</p>

            <table style="width: 100%; margin-top: 15px; border-collapse: collapse; border: 1px solid #e9ecef;">
                <tr>
                    <td style="padding: 10px; border: 1px solid #e9ecef; font-weight: bold;">Mata Kuliah</td>
                    <td style="padding: 10px; border: 1px solid #e9ecef;">{{ $daftarPelaporan->mataKuliah->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #e9ecef; font-weight: bold;">Status Verifikasi</td>
                    <td style="padding: 10px; border: 1px solid #e9ecef;">
                        <span class="status {{ strtolower($daftarPelaporan->status_verifikasi) }}">
                            @if ($daftarPelaporan->status_verifikasi === 'pending')
                                Menunggu Verifikasi
                            @elseif ($daftarPelaporan->status_verifikasi === 'approved')
                                Disetujui
                            @elseif ($daftarPelaporan->status_verifikasi === 'rejected')
                                Revisi
                            @elseif ($daftarPelaporan->status_verifikasi === 'draft')
                                Draft
                            @endif
                        </span>
                    </td>
                </tr>
                @if ($daftarPelaporan->deskripsi_verifikasi)
                    <tr>
                        <td style="padding: 10px; border: 1px solid #e9ecef; font-weight: bold;">Deskripsi Verifikasi
                        </td>
                        <td style="padding: 10px; border: 1px solid #e9ecef;">
                            {!! $daftarPelaporan->deskripsi_verifikasi !!}</td>
                    </tr>
                @endif
            </table>

            <p>
                @if ($daftarPelaporan->status_verifikasi === 'pending')
                    Kami sedang melakukan verifikasi laporan mata kuliah Anda. Mohon ditunggu, kami akan segera
                    menginformasikan
                    hasilnya.
                @elseif ($daftarPelaporan->status_verifikasi === 'approved')
                    Selamat! Laporan Mata kuliah Anda telah disetujui. Terima kasih atas partisipasi dan kerja sama
                    Anda.
                @elseif ($daftarPelaporan->status_verifikasi === 'rejected')
                    Kami mohon maaf, laporan mata kuliah Anda belum dapat disetujui dan membutuhkan revisi. Mohon
                    lakukan pembaruan sesuai dengan masukan yang
                    diberikan pada deskripsi verifikasi, lalu kirim kembali untuk proses persetujuan.
                @elseif ($daftarPelaporan->status_verifikasi === 'draft')
                    Status saat ini adalah draft. Silakan lengkapi data yang diperlukan untuk melanjutkan proses
                    verifikasi.
                @endif

            </p>

            <p>Silakan cek kembali status mata kuliah Anda untuk memastikan informasi telah sesuai. Jika ada pertanyaan
                lebih lanjut, jangan ragu untuk menghubungi tim kami.</p>

            <p><a href="{{ route('dashboard.pelaporan-prodi.show', $daftarPelaporan->id) }}" class="button">Lihat Detail
                    Mata Kuliah</a></p>

            <p class="note">*Email ini dikirim secara otomatis. Harap tidak membalas langsung email ini.</p>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>Hormat Kami,</p>
            <p><strong>Tim Admin Sistem Informasi Pelaporan IKU7 UNIMA</strong></p>
            <p><a href="mailto:iku7@unima.ac.id">Hubungi Dukungan</a> | <a
                    href="{{ route('dashboard.pelaporan-prodi.index') }}">Kunjungi Dashboard</a></p>
        </footer>
    </div>
</body>

</html>
