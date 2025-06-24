{{-- filepath: resources/views/antrean/detail_pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Antrean PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; background: #f7f7f7; color: #222; }
        .container { background: #fff; max-width: 600px; margin: 30px auto; padding: 30px 40px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); }
        .judul { font-size: 22px; font-weight: bold; margin-bottom: 25px; text-align: center; color: #2d7be5; letter-spacing: 1px; }
        .section { margin-bottom: 28px; }
        .row { display: flex; margin-bottom: 10px; }
        .label { width: 160px; font-weight: bold; color: #555; }
        .value { flex: 1; color: #222; }
        .nomor-antrian-box {
            margin: 0 auto 25px auto;
            background: #2d7be5;
            color: #fff;
            font-size: 48px;
            font-weight: bold;
            width: 180px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(45,123,229,0.13);
            letter-spacing: 2px;
        }
        .section-title {
            font-size: 15px;
            font-weight: bold;
            color: #2d7be5;
            margin-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="judul">Detail Antrean</div>
        <div class="nomor-antrian-box">
            {{ $antrean->nomor_antrian }}
        </div>
        <div class="section">
            <div class="section-title">Data Pasien</div>
            <div class="row">
                <div class="label">NIK Pasien:</div>
                <div class="value">{{ $antrean->nik_pasien }}</div>
            </div>
            <div class="row">
                <div class="label">Nama Pasien:</div>
                <div class="value">{{ $antrean->nama_pasien }}</div>
            </div>
            <div class="row">
                <div class="label">Alamat:</div>
                <div class="value">{{ $antrean->alamat_pasien }}</div>
            </div>
            <div class="row">
                <div class="label">Jenis Kelamin:</div>
                <div class="value">{{ $antrean->jenis_kelamin === 'L' ? 'Laki-laki' : ($antrean->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</div>
            </div>
            <div class="row">
                <div class="label">Tanggal Lahir:</div>
                <div class="value">{{ \Carbon\Carbon::parse($antrean->tanggal_lahir)->format('d M Y') }}</div>
            </div>
            <div class="row">
                <div class="label">Nomor WhatsApp:</div>
                <div class="value">{{ $antrean->nomor_whatsapp }}</div>
            </div>
        </div>
        <div class="section">
            <div class="section-title">Detail Kunjungan</div>
            <div class="row">
                <div class="label">Tanggal Kunjungan:</div>
                <div class="value">{{ \Carbon\Carbon::parse($antrean->tanggal_kunjungan)->format('d M Y') }}</div>
            </div>
            <div class="row">
                <div class="label">Status:</div>
                <div class="value">{{ ucfirst($antrean->status) }}</div>
            </div>
            <div class="row">
                <div class="label">Pembayaran:</div>
                <div class="value">{{ ucfirst($antrean->pembayaran) }}</div>
            </div>
            <div class="row">
                <div class="label">Poli:</div>
                <div class="value">{{ $antrean->polis->nama_poli ?? '-' }}</div>
            </div>
            <div class="row">
                <div class="label">Keluhan:</div>
                <div class="value">{{ $antrean->keluhan }}</div>
            </div>
        </div>
    </div>
</body>
</html>
