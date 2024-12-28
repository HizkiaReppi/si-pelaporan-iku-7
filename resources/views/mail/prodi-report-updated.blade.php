<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Mata Kuliah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            color: #212529;
        }

        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .header {
            background-color: #0056b3;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 18px;
        }

        .content {
            padding: 20px;
            line-height: 1.6;
        }

        .content p {
            margin: 0 0 15px;
        }

        .content h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 12px;
            border: 1px solid #dee2e6;
            text-align: left;
            font-size: 14px;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
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
            font-weight: bold;
            font-size: 14px;
            text-align: center;
            margin-top: 20px;
            display: block;
            width: max-content;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .note {
            font-style: italic;
            color: #6c757d;
            margin-top: 20px;
            font-size: 12px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            padding: 15px;
            background-color: #f3f4f6;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <header class="header">
            <h1>Laporan Mata Kuliah Diperbarui</h1>
        </header>

        <!-- Content -->
        <main class="content">
            <p>Yth. Bapak/Ibu Admin,</p>
            <p>Kami ingin menginformasikan bahwa program studi telah memperbarui laporan mata kuliah dengan rincian
                sebagai berikut:</p>

            <table class="table">
                <tr>
                    <th>Program Studi</th>
                    <td>{{ $pelaporan->prodi->name }}</td>
                </tr>
                <tr>
                    <th>Mata Kuliah</th>
                    <td>{{ $pelaporan->mataKuliah->name }}</td>
                </tr>
                <tr>
                    <th>Status Verifikasi</th>
                    <td>
                        <span class="status {{ strtolower($pelaporan->status_verifikasi) }}">
                            @if ($pelaporan->status_verifikasi === 'pending')
                                Menunggu Persetujuan
                            @elseif ($pelaporan->status_verifikasi === 'approved')
                                Disetujui
                            @elseif ($pelaporan->status_verifikasi === 'rejected')
                                Revisi
                            @elseif ($pelaporan->status_verifikasi === 'draft')
                                Draft
                            @endif
                        </span>
                    </td>
                </tr>
            </table>

            <p>Silakan klik tombol di bawah ini untuk melihat detail laporan mata kuliah:</p>
            <a href="{{ route('dashboard.pelaporan-admin.show', $pelaporan->id) }}" class="button">Lihat Laporan</a>

            <p class="note">*Email ini dikirim secara otomatis. Harap tidak membalas langsung email ini.</p>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>Hormat Kami,</p>
            <p><strong>Tim Admin Sistem Informasi Pelaporan IKU7 UNIMA</strong></p>
            <p>
                <a href="mailto:iku7@unima.ac.id">Hubungi Dukungan</a> |
                <a href="{{ route('dashboard.pelaporan-admin.index') }}">Kunjungi Dashboard</a>
            </p>
        </footer>
    </div>
</body>

</html>
