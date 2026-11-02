<?php
// tambah.php (CREATE)
require_once 'config/database.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$errors = [];
$categories = ['Romantis', 'Horor', 'Fantasi', 'Komedi', 'Drama', 'Misteri', 'Sci-Fi'];

$judul     = '';
$penulis   = '';
$kategori  = 'Romantis';
$ringkasan = '';
$isi       = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul     = trim($_POST['judul'] ?? '');
    $penulis   = trim($_POST['penulis'] ?? '');
    $kategori  = trim($_POST['kategori'] ?? '');
    $ringkasan = trim($_POST['ringkasan'] ?? '');
    $isi       = trim($_POST['isi'] ?? '');

    // Validasi
    if (empty($judul)) {
        $errors[] = 'Judul cerpen wajib diisi.';
    } elseif (mb_strlen($judul) < 3) {
        $errors[] = 'Judul minimal 3 karakter.';
    }

    if (empty($penulis)) {
        $errors[] = 'Nama penulis wajib diisi.';
    }

    if (empty($kategori) || !in_array($kategori, $categories)) {
        $errors[] = 'Pilih kategori yang valid.';
    }

    if (empty($isi)) {
        $errors[] = 'Isi cerita tidak boleh kosong.';
    } elseif (mb_strlen($isi) < 30) {
        $errors[] = 'Isi cerita terlalu singkat (minimal 30 karakter).';
    }

    // Auto ringkasan jika dikosongkan
    if (empty($ringkasan) && !empty($isi)) {
        $cleanIsi = strip_tags($isi);
        $ringkasan = mb_substr($cleanIsi, 0, 180) . (mb_strlen($cleanIsi) > 180 ? '...' : '');
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO cerpen (judul, penulis, kategori, ringkasan, isi, views)
                VALUES (:judul, :penulis, :kategori, :ringkasan, :isi, 0)
            ");
            
            $stmt->execute([
                ':judul'     => $judul,
                ':penulis'   => $penulis,
                ':kategori'  => $kategori,
                ':ringkasan' => $ringkasan,
                ':isi'       => $isi,
            ]);

            $newId = $pdo->lastInsertId();

            $_SESSION['flash_message'] = 'Cerpen berhasil diterbitkan.';
            $_SESSION['flash_type'] = 'success';
            header("Location: baca.php?id={$newId}");
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Gagal menyimpan ke database: ' . $e->getMessage();
        }
    }
}

$pageTitle = 'Tulis Cerpen Baru';
require_once 'includes/header.php';
?>

<div class="form-box">
    <div class="form-head">
        <h1>Tulis Cerita Baru</h1>
        <p>Tuangkan karya tulisan Anda dengan fokus dan tanpa distraksi.</p>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="toast-alert toast-error" style="display: block; margin-bottom: 24px;">
            <strong>Perhatian:</strong>
            <ul style="padding-left: 20px; margin-top: 6px;">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="minimal-card">
        <form method="POST" action="tambah.php">
            <!-- Judul -->
            <div class="field">
                <label class="field-label" for="judul">Judul Cerita</label>
                <input 
                    type="text" 
                    id="judul" 
                    name="judul" 
                    class="input-clean" 
                    placeholder="Masukkan judul cerita..." 
                    value="<?= htmlspecialchars($judul) ?>" 
                    required 
                    maxlength="200"
                >
            </div>

            <!-- Penulis & Kategori -->
            <div class="field-grid">
                <div class="field">
                    <label class="field-label" for="penulis">Nama Penulis</label>
                    <input 
                        type="text" 
                        id="penulis" 
                        name="penulis" 
                        class="input-clean" 
                        placeholder="Nama atau samaran..." 
                        value="<?= htmlspecialchars($penulis) ?>" 
                        required 
                        maxlength="100"
                    >
                </div>

                <div class="field">
                    <label class="field-label" for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" class="input-clean" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat ?>" <?= $kategori === $cat ? 'selected' : '' ?>>
                                <?= $cat ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="field">
                <label class="field-label" for="ringkasan">Sinopsis Singkat (Opsional)</label>
                <textarea 
                    id="ringkasan" 
                    name="ringkasan" 
                    class="input-clean" 
                    rows="3" 
                    placeholder="Ringkasan cerita sebagai pengantar pembaca..."
                    maxlength="300"
                ><?= htmlspecialchars($ringkasan) ?></textarea>
            </div>

            <!-- Isi Cerita -->
            <div class="field">
                <label class="field-label" for="isiCerpen">Naskah Cerita</label>
                <textarea 
                    id="isiCerpen" 
                    name="isi" 
                    class="input-clean story-text" 
                    rows="14" 
                    placeholder="Mulai menulis cerita Anda di sini..."
                    required
                ><?= htmlspecialchars($isi) ?></textarea>
                <div class="field-hint">
                    <span id="wordCount">0 kata</span>
                    <span id="readTimeEst">&plusmn; 1 menit baca</span>
                </div>
            </div>

            <div class="btn-row">
                <a href="index.php" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Terbitkan</button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
