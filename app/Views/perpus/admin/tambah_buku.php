<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Perpustakaan</title>
    <link rel="stylesheet" href="<?= base_url('perpus/css/admin_style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>
    <div class="admin-container">
        <?php include APPPATH . 'Views/perpus/admin/sidebar.php'; ?>

        <div class="main-content">
            <?php 
                $page_title = 'Tambah Koleksi';
                include APPPATH . 'Views/perpus/admin/topbar.php'; 
            ?>

            <main class="content-area">
                <div class="card-admin" style="margin-bottom: 20px; max-width: 800px;">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: white;"><i class="bi bi-journal-plus"></i> Tambah Koleksi Baru</h2>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Daftarkan buku baru ke dalam sistem katalog perpustakaan.</p>
                </div>

                <div class="form-solid">
                    <form action="<?= base_url('perpus/simpan-buku') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="form-row-modern">
                            <div class="form-group-modern">
                                <label for="kode_buku">Kode Referensi</label>
                                <input type="text" id="kode_buku" name="kode_buku" placeholder="BI-001" required>
                            </div>
                            
                            <div class="form-group-modern">
                                <label for="kategori">Kategori Buku</label>
                                <select id="kategori" name="kategori" required onchange="updateKurikulum()">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Fiksi">Fiksi</option>
                                    <option value="Non-Fiksi">Non-Fiksi</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label for="kurikulum">Kurikulum</label>
                            <select id="kurikulum" name="kurikulum">
                                <option value="">-- Pilih Kurikulum --</option>
                                <option value="KTSP 2006">KTSP 2006</option>
                                <option value="Kurikulum 2013">Kurikulum 2013</option>
                                <option value="Kurikulum Merdeka">Kurikulum Merdeka</option>
                            </select>
                        </div>

                        <div class="form-group-modern">
                            <label for="judul">Judul Lengkap Buku</label>
                            <input type="text" id="judul" name="judul" placeholder="Masukkan judul utama buku" required>
                        </div>
                        <div class="form-row-modern">
                            <div class="form-group-modern">
                                <label for="pengarang">Penulis / Pengarang</label>
                                <input type="text" id="pengarang" name="pengarang" placeholder="Nama penulis" required>
                            </div>
                            
                            <div class="form-group-modern">
                                <label for="penerbit">Penerbit</label>
                                <input type="text" id="penerbit" name="penerbit" placeholder="Perusahaan penerbit" required>
                            </div>
                        </div>

                        <div class="form-row-modern">
                            <div class="form-group-modern">
                                <label for="tahun_terbit">Tahun Rilis</label>
                                <input type="number" id="tahun_terbit" name="tahun_terbit" min="1900" max="<?= date('Y') ?>" placeholder="<?= date('Y') ?>" required>
                            </div>
                            
                            <div class="form-group-modern">
                                <label for="stok">Total Inventaris</label>
                                <input type="number" id="stok" name="stok" min="1" placeholder="Jumlah fisik buku" required>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label>Sampul Depan (Cover)</label>
                            <div class="upload-area" onclick="document.getElementById('gambar').click()">
                                <i class="bi bi-cloud-arrow-up" style="font-size: 2.5rem; color: var(--primary); display: block; margin-bottom: 10px;"></i>
                                <span style="font-weight: 600; color: #34495e;">Klik untuk upload gambar cover</span>
                                <p style="font-size: 0.8rem; color: #bdc3c7;">PNG, JPG, JPEG (Maks. 2MB)</p>
                                <input type="file" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)" style="display: none;">
                            </div>
                            <div id="preview-container" style="margin-top: 20px; display: none; text-align: center;">
                                <div style="position: relative; display: inline-block;">
                                    <img id="preview-image" style="max-width: 180px; border-radius: 12px; border: 4px solid white; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                                    <div style="position: absolute; top: 10px; right: 10px; background: #2ecc71; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                                        <i class="bi bi-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 40px; display: flex; gap: 15px;">
                            <button type="submit" class="btn-primary-modern" style="flex: 1; justify-content: center; padding: 15px;">
                                <i class="bi bi-save-fill"></i> Simpan Koleksi
                            </button>
                            <a href="<?= base_url('perpus/kelola-buku') ?>" class="btn-primary-modern" style="background: #f1f2f6; color: #7f8c8d; box-shadow: none; padding: 15px;">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        function updateKurikulum() {
            // Fungsi ini dipanggil saat kategori berubah (dipertahankan untuk kompatibilitas)
        }

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB');
                    event.target.value = '';
                    document.getElementById('preview-container').style.display = 'none';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview-container').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
