<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Perpustakaan - <?= esc($user['nama_lengkap']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            color: white;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #00d2ff, #3a7bd5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-header p {
            color: rgba(255,255,255,0.5);
            font-size: 0.9rem;
        }

        .cards-wrapper {
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 40px;
        }

        .card-label {
            text-align: center;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255,255,255,0.4);
            margin-bottom: 15px;
        }

        /* === KARTU UKURAN KTP (85.6mm x 53.98mm) === */
        .kartu-perpus {
            width: 85.6mm;
            height: 53.98mm;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.1);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .kartu-perpus:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 35px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.15);
        }

        /* SISI DEPAN */
        .kartu-depan {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 40%, #0f3460 100%);
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 8mm 6mm 6mm 6mm;
        }

        .kartu-depan::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -20%;
            width: 60%;
            height: 80%;
            background: radial-gradient(circle, rgba(58, 123, 213, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .kartu-depan::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 50%;
            height: 60%;
            background: radial-gradient(circle, rgba(0, 210, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .kartu-header-row {
            display: flex;
            align-items: center;
            gap: 3mm;
            margin-bottom: 3mm;
            position: relative;
            z-index: 1;
        }

        .kartu-logo {
            width: 10mm;
            height: 10mm;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            border-radius: 3mm;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5mm;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 3px 10px rgba(58, 123, 213, 0.4);
        }

        .kartu-title-group {
            flex: 1;
        }

        .kartu-title {
            font-size: 3mm;
            font-weight: 800;
            color: white;
            letter-spacing: 0.3mm;
            line-height: 1.2;
        }

        .kartu-subtitle {
            font-size: 1.8mm;
            color: rgba(255,255,255,0.5);
            font-weight: 500;
            letter-spacing: 0.5mm;
            text-transform: uppercase;
        }

        .kartu-divider {
            height: 0.3mm;
            background: linear-gradient(90deg, rgba(58, 123, 213, 0.6), rgba(0, 210, 255, 0.6), transparent);
            margin-bottom: 2.5mm;
            border-radius: 1mm;
            position: relative;
            z-index: 1;
        }

        .kartu-info-section {
            display: flex;
            gap: 3mm;
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .kartu-user-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 1.5mm;
        }

        .kartu-field {
            display: flex;
            flex-direction: column;
        }

        .kartu-field-label {
            font-size: 1.5mm;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 0.5mm;
            font-weight: 600;
        }

        .kartu-field-value {
            font-size: 2.5mm;
            font-weight: 700;
            color: white;
            line-height: 1.3;
        }

        .kartu-barcode-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 2mm;
            padding: 1.5mm;
            min-width: 25mm;
        }

        .kartu-barcode-area svg {
            width: 100% !important;
            height: 10mm !important;
        }

        .barcode-label {
            font-size: 1.5mm;
            color: #333;
            font-weight: 700;
            letter-spacing: 0.3mm;
            margin-top: 0.5mm;
        }

        /* SISI BELAKANG */
        .kartu-belakang {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 5mm 6mm;
            color: #2c3e50;
        }

        .kartu-belakang-header {
            text-align: center;
            margin-bottom: 3mm;
            padding-bottom: 2mm;
            border-bottom: 0.3mm solid #dee2e6;
        }

        .kartu-belakang-header h3 {
            font-size: 2.5mm;
            font-weight: 800;
            color: #1a1a2e;
            letter-spacing: 0.3mm;
        }

        .kartu-belakang-header p {
            font-size: 1.8mm;
            color: #6c757d;
            font-weight: 500;
        }

        .kartu-rules {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1.2mm;
        }

        .kartu-rules h4 {
            font-size: 2mm;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 0.5mm;
        }

        .kartu-rule-item {
            font-size: 1.6mm;
            color: #495057;
            line-height: 1.4;
            padding-left: 2.5mm;
            position: relative;
        }

        .kartu-rule-item::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #3a7bd5;
            font-weight: 700;
        }

        .kartu-footer-info {
            margin-top: auto;
            padding-top: 2mm;
            border-top: 0.3mm solid #dee2e6;
            text-align: center;
        }

        .kartu-footer-info p {
            font-size: 1.5mm;
            color: #6c757d;
        }

        .kartu-footer-info .highlight {
            color: #3a7bd5;
            font-weight: 700;
        }

        /* TOMBOL AKSI */
        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn-action {
            padding: 14px 32px;
            border: none;
            border-radius: 14px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
        }

        .btn-print {
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            color: white;
            box-shadow: 0 10px 30px rgba(58, 123, 213, 0.3);
        }

        .btn-print:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(58, 123, 213, 0.4);
        }

        .btn-back {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .btn-back:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-3px);
        }

        /* PRINT STYLES */
        @media print {
            @page {
                size: 85.6mm 53.98mm;
                margin: 0;
            }

            body {
                background: none !important;
                padding: 0 !important;
                margin: 0 !important;
                min-height: auto !important;
            }

            .page-header,
            .actions,
            .card-label,
            .no-print {
                display: none !important;
            }

            .cards-wrapper {
                gap: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .card-container {
                page-break-after: always;
                margin: 0 !important;
            }

            .card-container:last-child {
                page-break-after: avoid;
            }

            .kartu-perpus {
                box-shadow: none !important;
                border-radius: 0 !important;
                width: 85.6mm !important;
                height: 53.98mm !important;
                transform: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="page-header no-print">
        <h1><i class="bi bi-credit-card-2-front-fill"></i> Cetak Kartu Perpustakaan</h1>
        <p>Preview kartu untuk <?= esc($user['nama_lengkap']) ?> — Ukuran standar KTP (85.6mm × 53.98mm)</p>
    </div>

    <div class="cards-wrapper">
        <!-- SISI DEPAN -->
        <div class="card-container">
            <div class="card-label no-print">Sisi Depan</div>
            <div class="kartu-perpus">
                <div class="kartu-depan">
                    <div class="kartu-header-row">
                        <div class="kartu-logo">
                            <i class="bi bi-book-half"></i>
                        </div>
                        <div class="kartu-title-group">
                            <div class="kartu-title">PERPUSTAKAAN</div>
                            <div class="kartu-subtitle">Kartu Anggota Perpustakaan</div>
                        </div>
                    </div>

                    <div class="kartu-divider"></div>

                    <div class="kartu-info-section">
                        <div class="kartu-user-details">
                            <div class="kartu-field">
                                <span class="kartu-field-label">Nama Lengkap</span>
                                <span class="kartu-field-value"><?= esc($user['nama_lengkap']) ?></span>
                            </div>
                            <div class="kartu-field">
                                <span class="kartu-field-label">Kelas</span>
                                <span class="kartu-field-value"><?= esc($user['kelas'] ?? '-') ?></span>
                            </div>
                            <div class="kartu-field">
                                <span class="kartu-field-label">No. Anggota</span>
                                <span class="kartu-field-value"><?= esc($barcode_value) ?></span>
                            </div>
                        </div>
                        <div class="kartu-barcode-area">
                            <svg id="barcode-front"></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SISI BELAKANG -->
        <div class="card-container">
            <div class="card-label no-print">Sisi Belakang</div>
            <div class="kartu-perpus">
                <div class="kartu-belakang">
                    <div class="kartu-belakang-header">
                        <h3>PERPUSTAKAAN SEKOLAH</h3>
                        <p>Kartu ini adalah tanda keanggotaan resmi perpustakaan</p>
                    </div>

                    <div class="kartu-rules">
                        <h4>Peraturan:</h4>
                        <div class="kartu-rule-item">Kartu ini tidak dapat dipindahtangankan</div>
                        <div class="kartu-rule-item">Wajib dibawa saat meminjam buku</div>
                        <div class="kartu-rule-item">Segera lapor jika kartu hilang/rusak</div>
                        <div class="kartu-rule-item">Maksimal peminjaman 3 buku / 7 hari</div>
                        <div class="kartu-rule-item">Keterlambatan dikenakan denda Rp 2.000</div>
                    </div>

                    <div class="kartu-footer-info">
                        <p>Berlaku sejak <span class="highlight"><?= date('d M Y', strtotime($user['created_at'])) ?></span></p>
                        <p>Scan barcode pada sisi depan untuk verifikasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="actions no-print">
        <button class="btn-action btn-print" onclick="window.print()">
            <i class="bi bi-printer-fill"></i> Cetak Kartu
        </button>
        <a href="<?= base_url('perpus/kelola-user') ?>" class="btn-action btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <script>
        // Generate barcode
        JsBarcode("#barcode-front", "<?= $barcode_value ?>", {
            format: "CODE128",
            width: 1.2,
            height: 30,
            displayValue: false,
            margin: 2,
            background: "transparent"
        });
    </script>
</body>
</html>
