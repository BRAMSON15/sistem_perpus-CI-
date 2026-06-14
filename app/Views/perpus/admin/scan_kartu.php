<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Kartu - Perpustakaan</title>
    <link rel="stylesheet" href="<?= base_url('perpus/css/admin_style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .scan-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        @media (max-width: 1024px) {
            .scan-container {
                grid-template-columns: 1fr;
            }
        }

        .scan-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            display: flex;
            flex-direction: column;
        }

        .scan-panel h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .scan-panel h3 i {
            color: #3498db;
            font-size: 1.4rem;
        }

        .scan-panel .subtitle {
            color: rgba(255,255,255,0.5);
            font-size: 0.85rem;
            margin-bottom: 25px;
        }

        .scan-input-group {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .scan-input {
            flex: 1;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.08);
            border: 2px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            font-family: 'Inter', monospace;
            letter-spacing: 1px;
            outline: none;
            transition: all 0.3s;
        }

        .scan-input::placeholder {
            color: rgba(255,255,255,0.3);
            font-weight: 400;
            letter-spacing: 0;
        }

        .scan-input:focus {
            border-color: #3498db;
            background: rgba(52, 152, 219, 0.08);
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.15);
        }

        .btn-scan {
            padding: 16px 28px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            white-space: nowrap;
            font-family: 'Inter', sans-serif;
        }

        .btn-scan:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(52, 152, 219, 0.3);
        }

        .btn-scan:active {
            transform: translateY(0);
        }

        .btn-scan:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Scan Result Card */
        .scan-result {
            display: none;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
            margin-top: 10px;
            animation: fadeInUp 0.4s ease;
        }

        .scan-result.show {
            display: block;
        }

        .scan-result.success {
            border-color: rgba(46, 204, 113, 0.3);
            background: rgba(46, 204, 113, 0.05);
        }

        .scan-result.error {
            border-color: rgba(231, 76, 60, 0.3);
            background: rgba(231, 76, 60, 0.05);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .result-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .result-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .result-icon.success {
            background: rgba(46, 204, 113, 0.15);
            color: #2ecc71;
        }

        .result-icon.error {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
        }

        .result-title {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .result-subtitle {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.5);
        }

        .result-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .result-field {
            background: rgba(255, 255, 255, 0.04);
            padding: 12px 15px;
            border-radius: 10px;
        }

        .result-field-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.4);
            font-weight: 600;
            margin-bottom: 4px;
        }

        .result-field-value {
            font-size: 0.95rem;
            font-weight: 700;
            color: white;
        }

        .status-badge-aktif {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            background: rgba(46, 204, 113, 0.15);
            color: #2ecc71;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .status-badge-aktif::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #2ecc71;
            border-radius: 50%;
            animation: pulse-dot 1.5s ease infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        /* Today Activity Table */
        .scan-history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .scan-count-badge {
            background: rgba(52, 152, 219, 0.15);
            color: #3498db;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <?php include APPPATH . 'Views/perpus/admin/sidebar.php'; ?>

        <div class="main-content">
            <?php 
                $page_title = 'Scan Kartu';
                include APPPATH . 'Views/perpus/admin/topbar.php'; 
            ?>

            <main class="content-area">
                <div class="scan-container">
                    <!-- Panel Scan -->
                    <div class="scan-panel">
                        <h3><i class="bi bi-upc-scan"></i> Scan Barcode</h3>
                        <p class="subtitle">Masukkan atau scan kode barcode kartu perpustakaan siswa</p>

                        <div class="scan-input-group">
                            <input type="text" 
                                   id="barcodeInput" 
                                   class="scan-input" 
                                   placeholder="Contoh: LIB-00001" 
                                   autocomplete="off"
                                   autofocus>
                            <button type="button" id="btnScan" class="btn-scan" onclick="prosesScan()">
                                <i class="bi bi-search"></i> Scan
                            </button>
                        </div>

                        <div id="scanResult" class="scan-result">
                            <div class="result-header">
                                <div id="resultIcon" class="result-icon success">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div>
                                    <div id="resultTitle" class="result-title">Scan Berhasil!</div>
                                    <div id="resultSubtitle" class="result-subtitle">Data siswa ditemukan</div>
                                </div>
                            </div>
                            <div id="resultDetails" class="result-details">
                                <!-- Filled by JS -->
                            </div>
                        </div>
                    </div>

                    <!-- Panel Riwayat Hari Ini -->
                    <div class="scan-panel">
                        <div class="scan-history-header">
                            <div>
                                <h3><i class="bi bi-clock-history"></i> Aktivitas Hari Ini</h3>
                                <p class="subtitle">Riwayat scan kartu perpustakaan hari ini</p>
                            </div>
                            <span class="scan-count-badge" id="scanCount"><?= count($scan_today) ?> scan</span>
                        </div>

                        <div class="table-container-admin" style="box-shadow: none; border-radius: 14px; flex: 1;">
                            <table>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="scanTableBody">
                                    <?php if(empty($scan_today)): ?>
                                        <tr id="emptyRow">
                                            <td colspan="5" style="text-align: center; padding: 60px 20px;">
                                                <i class="bi bi-upc-scan" style="font-size: 3rem; color: #e1e8f0; display: block; margin-bottom: 10px;"></i>
                                                <h4 style="color: #bdc3c7; font-weight: 600;">Belum ada scan hari ini</h4>
                                                <p style="color: #dfe6e9; font-size: 0.8rem;">Scan kartu perpustakaan untuk memulai</p>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach($scan_today as $i => $scan): ?>
                                            <tr>
                                                <td style="color: #95a5a6; font-size: 0.8rem;"><?= $i + 1 ?></td>
                                                <td>
                                                    <div style="font-weight: 700; color: #2c3e50;"><?= esc($scan['nama_lengkap']) ?></div>
                                                </td>
                                                <td><span class="badge-modern" style="background: rgba(52, 152, 219, 0.1); color: #3498db;"><?= esc($scan['kelas']) ?></span></td>
                                                <td style="font-size: 0.85rem; color: #7f8c8d;"><?= date('H:i:s', strtotime($scan['scan_time'])) ?></td>
                                                <td>
                                                    <span class="badge-modern" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                                                        <i class="bi bi-check-circle-fill"></i> Aktif
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        const barcodeInput = document.getElementById('barcodeInput');
        const btnScan = document.getElementById('btnScan');
        const scanResult = document.getElementById('scanResult');
        const resultIcon = document.getElementById('resultIcon');
        const resultTitle = document.getElementById('resultTitle');
        const resultSubtitle = document.getElementById('resultSubtitle');
        const resultDetails = document.getElementById('resultDetails');
        const scanTableBody = document.getElementById('scanTableBody');
        const scanCount = document.getElementById('scanCount');
        let currentScanCount = <?= count($scan_today) ?>;

        // Enter key to scan
        barcodeInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                prosesScan();
            }
        });

        function prosesScan() {
            const barcode = barcodeInput.value.trim();
            if (!barcode) {
                showError('Masukkan kode barcode terlebih dahulu!');
                barcodeInput.focus();
                return;
            }

            btnScan.disabled = true;
            btnScan.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';

            fetch('<?= base_url('perpus/proses-scan-kartu') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'barcode=' + encodeURIComponent(barcode)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showSuccess(data);
                    addToTable(data.data);
                    barcodeInput.value = '';
                } else {
                    showError(data.message);
                }
            })
            .catch(error => {
                showError('Terjadi kesalahan jaringan. Silakan coba lagi.');
                console.error(error);
            })
            .finally(() => {
                btnScan.disabled = false;
                btnScan.innerHTML = '<i class="bi bi-search"></i> Scan';
                barcodeInput.focus();
            });
        }

        function showSuccess(data) {
            scanResult.className = 'scan-result show success';
            resultIcon.className = 'result-icon success';
            resultIcon.innerHTML = '<i class="bi bi-check-circle-fill"></i>';
            resultTitle.textContent = 'Scan Berhasil!';
            resultSubtitle.textContent = 'Identitas siswa terverifikasi';

            resultDetails.innerHTML = `
                <div class="result-field">
                    <div class="result-field-label">Nama Lengkap</div>
                    <div class="result-field-value">${data.data.nama}</div>
                </div>
                <div class="result-field">
                    <div class="result-field-label">Kelas</div>
                    <div class="result-field-value">${data.data.kelas || '-'}</div>
                </div>
                <div class="result-field">
                    <div class="result-field-label">Waktu Scan</div>
                    <div class="result-field-value">${data.data.waktu}</div>
                </div>
                <div class="result-field">
                    <div class="result-field-label">Status</div>
                    <div class="result-field-value">
                        <span class="status-badge-aktif">Aktif</span>
                    </div>
                </div>
            `;
        }

        function showError(message) {
            scanResult.className = 'scan-result show error';
            resultIcon.className = 'result-icon error';
            resultIcon.innerHTML = '<i class="bi bi-x-circle-fill"></i>';
            resultTitle.textContent = 'Scan Gagal!';
            resultSubtitle.textContent = message;
            resultDetails.innerHTML = '';
        }

        function addToTable(data) {
            currentScanCount++;
            scanCount.textContent = currentScanCount + ' scan';

            // Remove empty row if exists
            const emptyRow = document.getElementById('emptyRow');
            if (emptyRow) emptyRow.remove();

            const newRow = document.createElement('tr');
            newRow.style.animation = 'fadeInUp 0.4s ease';
            newRow.innerHTML = `
                <td style="color: #95a5a6; font-size: 0.8rem;">${currentScanCount}</td>
                <td>
                    <div style="font-weight: 700; color: #2c3e50;">${data.nama}</div>
                </td>
                <td><span class="badge-modern" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">${data.kelas || '-'}</span></td>
                <td style="font-size: 0.85rem; color: #7f8c8d;">${data.waktu}</td>
                <td>
                    <span class="badge-modern" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                        <i class="bi bi-check-circle-fill"></i> Aktif
                    </span>
                </td>
            `;

            // Insert at the top of the table body
            if (scanTableBody.firstChild) {
                scanTableBody.insertBefore(newRow, scanTableBody.firstChild);
            } else {
                scanTableBody.appendChild(newRow);
            }
        }
    </script>
</body>
</html>
