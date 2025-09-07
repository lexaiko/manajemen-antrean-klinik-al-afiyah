<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Antrean</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }

        .header {
            position: relative;
            margin-bottom: 10px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            min-height: 100px;
        }

        .header-logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .header-content {
            text-align: center;
            width: 100%;
            margin: 0 auto;
        }

        .clinic-name {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
            color: #333;
        }

        .clinic-address {
            font-size: 10px;
            color: #666;
            margin: 5px 0;
        }

        .clinic-contact {
            font-size: 9px;
            color: #888;
            margin: 5px 0;
        }

        .info-section {
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-antri { background-color: #fff3cd; color: #856404; }
        .status-dilayani { background-color: #cce5ff; color: #004085; }
        .status-selesai { background-color: #d4edda; color: #155724; }
        .status-ditangguhkan { background-color: #f8d7da; color: #721c24; }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .signature-area {
            margin-top: 50px;
            text-align: right;
        }
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo Klinik" class="header-logo">
        <div class="header-content">
            <div class="clinic-name">Laporan Antrean Klinik Al Afiyah</div>
            <div class="clinic-address">
                Jl. Raya Blimbingsari No. 45, Blimbingsari, Rogojampi, Kabupaten Banyuwangi, Jawa Timur 68462
            </div>
            <div class="clinic-contact">
                Telp: (0333) 421-234 | Email: info@klinikalaafiyah.com | Website: www.klinikalaafiyah.com
            </div>
        </div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span><span class="info-label">Periode:</span>
                @if($tanggal_mulai && $tanggal_akhir)
                    {{ \Carbon\Carbon::parse($tanggal_mulai)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($tanggal_akhir)->translatedFormat('d F Y') }}
                @elseif($tanggal_mulai)
                    Mulai {{ \Carbon\Carbon::parse($tanggal_mulai)->translatedFormat('d F Y') }}
                @elseif($tanggal_akhir)
                    Sampai {{ \Carbon\Carbon::parse($tanggal_akhir)->translatedFormat('d F Y') }}
                @else
                    Semua Tanggal
                @endif
            </span>
        </div>
        <div class="info-row">
            <span><span class="info-label">Filter Status:</span>
                @if($status_filter)
                    {{ ucfirst($status_filter) }}
                @else
                    Semua Status
                @endif
            </span>
            <span><span class="info-label">Filter Poli:</span>
                @if($poli_filter)
                    @php
                        $selectedPoli = $polis->find($poli_filter);
                    @endphp
                    {{ $selectedPoli ? $selectedPoli->nama_poli : 'Tidak Diketahui' }}
                @else
                    Semua Poli
                @endif
            </span>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="12%">Tanggal</th>
                    <th width="8%">No. Antrian</th>
                    <th width="20%">Nama Pasien</th>
                    <th width="15%">Poli</th>
                    <th width="10%">Status</th>
                    <th width="10%">Pembayaran</th>
                    <th width="20%">Keluhan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($antrian as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d/m/Y') }}</td>
                        <td>{{ $item->nomor_antrian }}</td>
                        <td>{{ $item->nama_pasien }}</td>
                        <td>{{ $item->polis->nama_poli ?? 'Tidak Diketahui' }}</td>
                        <td>
                            <span class="status-badge status-{{ $item->status }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ ucfirst($item->pembayaran) }}</td>
                        <td>{{ Str::limit($item->keluhan, 50) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="no-data">
                            Tidak ada data antrean untuk periode yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($antrian->count() > 0)
        <div class="info-section" style="margin-top: 20px;">
            <div class="info-block">
                <span class="info-label">Total Data:</span>
                <span class="info-value">{{ $antrian->count() }} antrean</span>
            </div>
            <div class="info-block">
                <span class="info-label">Tanggal Cetak:</span>
                <span class="info-value">{{ $tanggal_cetak }}</span>
            </div>
        </div>
    @endif

    {{-- <div class="signature-area">
        <p>Banyuwangi, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Penanggung Jawab,</p>
        <br><br><br>
        <p>_________________________</p>
        <p>{{ auth()->user()->name }}</p>
    </div> --}}
</body>
</html>
