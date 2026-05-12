<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Perpustakaan</title>
    <link rel="stylesheet" href="<?= base_url('perpus/css/admin_style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>
    <div class="admin-container">
        <?php include APPPATH . 'Views/perpus/admin/sidebar.php'; ?>

        <div class="main-content">
            <?php 
                $page_title = 'Edit Koleksi';
                include APPPATH . 'Views/perpus/admin/topbar.php'; 
            ?>

            <main class="content-area">
                <div class="card-admin" style="margin-bottom: 20px; max-width: 800px;">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: white;"><i class="bi bi-pencil-square"></i> Edit Data Koleksi</h2>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Memperbarui informasi untuk buku: <strong><?= esc($buku['judul']) ?></strong></p>
                </div>

                <div class="form-solid">
                    <form action="<?= base_url('perpus/update-buku/' . $buku['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="form-row-modern">
                            <div class="form-group-modern">
                                <label for="kode_buku">Kode Referensi</label>
                                <input type="text" id="kode_buku" name="kode_buku" value="<?= esc($buku['kode_buku']) ?>" required>
                            </div>
                            
                            <div class="form-group-modern">
                                <label for="kategori">Kategori Buku</label>
                                <select id="kategori" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php $cats = ['Fiksi', 'Non-Fiksi', 'Sains', 'Teknologi', 'Sejarah', 'Biografi', 'Pendidikan', 'Agama']; ?>
                                    <?php foreach($cats as $cat): ?>
                                        <option value="<?= $cat ?>" <?= $buku['kategori'] == $cat ? 'selected' : '' ?>><?= $cat ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label for="judul">Judul Lengkap Buku</label>
                            <input type="text" id="judul" name="judul" value="<?= esc($buku['judul']) ?>" required>
                        </div>

                        <div class="form-row-modern">
                            <div class="form-group-modern">
                                <label for="pengarang">Penulis / Pengarang</label>
                                <input type="text" id="pengarang" name="pengarang" value="<?= esc($buku['pengarang']) ?>" required>
                            </div>
                            
                            <div class="form-group-modern">
                                <label for="penerbit">Penerbit</label>
                                <input type="text" id="penerbit" name="penerbit" value="<?= esc($buku['penerbit']) ?>" required>
                            </div>
                        </div>

                        <div class="form-row-modern">
                            <div class="form-group-modern">
                                <label for="tahun_terbit">Tahun Rilis</label>
                                <input type="number" id="tahun_terbit" name="tahun_terbit" min="1900" max="<?= date('Y') ?>" value="<?= esc($buku['tahun_terbit']) ?>" required>
                            </div>
                            
                            <div class="form-group-modern">
                                <label for="stok">Total Inventaris</label>
                                <input type="number" id="stok" name="stok" min="1" value="<?= esc($buku['stok']) ?>" required>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label>Update Sampul (Opsional)</label>
                            <div style="display: flex; gap: 20px; align-items: flex-start; margin-bottom: 20px;">
                                <?php if($buku['gambar'] && file_exists(FCPATH . 'uploads/buku/' . $buku['gambar'])): ?>
                                    <div style="text-align: center;">
                                        <img src="<?= base_url('uploads/buku/' . $buku['gambar']) ?>" style="width: 100px; height: 140px; border-radius: 12px; object-fit: cover; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                        <p style="font-size: 0.7rem; color: #bdc3c7; margin-top: 5px;">Saat Ini</p>
                                    </div>
                                <?php endif; ?>
                                
                                <div style="flex: 1;">
                                    <div class="upload-area" onclick="document.getElementById('gambar').click()">
                                        <i class="bi bi-image" style="font-size: 1.5rem; color: var(--primary);"></i>
                                        <span style="font-weight: 600; color: #34495e;">Pilih Gambar Baru</span>
                                        <input type="file" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)" style="display: none;">
                                    </div>
                                    <p style="font-size: 0.75rem; color: #bdc3c7; margin-top: 10px;">Format: PNG, JPG (Maks. 2MB). Biarkan kosong jika tidak ingin ganti.</p>
                                </div>
                            </div>
                            
                            <div id="preview-container" style="display: none; text-align: center; background: #f8faff; padding: 20px; border-radius: 20px; border: 2px dashed var(--primary);">
                                <p style="font-size: 0.8rem; font-weight: 700; color: var(--primary); margin-bottom: 10px;">PREVIEW BARU</p>
                                <img id="preview-image" style="max-width: 150px; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                            </div>
                        </div>

                        <div style="margin-top: 40px; display: flex; gap: 15px;">
                            <button type="submit" class="btn-primary-modern" style="flex: 1; justify-content: center; padding: 15px;">
                                <i class="bi bi-save-fill"></i> Simpan Perubahan
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
