<?php
// edit.php (UPDATE)
require_once 'config/database.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['flash_message'] = 'ID cerpen tidak valid.';
    $_SESSION['flash_type'] = 'error';
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM cerpen WHERE id = :id");
$stmt->execute([':id' => $id]);
$story = $stmt->fetch();

if (!$story) {
    $_SESSION['flash_message'] = 'Cerpen tidak ditemukan.';
    $_SESSION['flash_type'] = 'error';
    header('Location: index.php');
    exit;
}

$errors = [];
$categories = ['Romantis', 'Horor', 'Fantasi', 'Komedi', 'Drama', 'Misteri', 'Sci-Fi'];

$judul     = $story['judul'];
$penulis   = $story['penulis'];
$kategori  = $story['kategori'];
$ringkasan = $story['ringkasan'];
$isi       = $story['isi'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul     = trim($_POST['judul'] ?? '');
    $penulis   = trim($_POST['penulis'] ?? '');
    $kategori  = trim($_POST['kategori'] ?? '');
    $ringkasan = trim($_POST['ringkasan'] ?? '');
    $isi       = trim($_POST['isi'] ?? '');

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

    if (empty($ringkasan) && !empty($isi)) {
        $cleanIsi = strip_tags($isi);
        $ringkasan = mb_substr($cleanIsi, 0, 180) . (mb_strlen($cleanIsi) > 180 ? '...' : '');
    }

    if (empty($errors)) {
        try {
            $updateStmt = $pdo->prepare("
                UPDATE cerpen 
                SET judul = :judul,
                    penulis = :penulis,
                    kategori = :kategori,
                    ringkasan = :ringkasan,
                    isi = :isi,
                    updated_at = NOW()
                WHERE id = :id
            ");

            $updateStmt->execute([
                ':judul'     => $judul,
                ':penulis'   => $penulis,
                ':kategori'  => $kategori,
                ':ringkasan' => $ringkasan,
                ':isi'       => $isi,
                ':id'        => $id,
            ]);

            $_SESSION['flash_message'] = 'Perubahan cerpen berhasil disimpan.';
            $_SESSION['flash_type'] = 'success';
            header("Location: baca.php?id={$id}");
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Gagal memperbarui database: ' . $e->getMessage();
        }
    }
}

$pageTitle = 'Edit Cerita';
require_once 'includes/header.php';
?>

<div class="form-box">
    <div class="form-head">
        <h1>Edit Cerita</h1>
        <p>Perbarui judul atau isi naskah cerita Anda.</p>
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
        <form method="POST" action="edit.php?id=<?= $id ?>">
            <input type="hidden" name="id" value="<?= $id ?>">

            <!-- Judul -->
            <div class="field">
                <label class="field-label" for="judul">Judul Cerita</label>
                <input 
                    type="text" 
                    id="judul" 
                    name="judul" 
                    class="input-clean" 
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
                <label class="field-label" for="ringkasan">Sinopsis Singkat</label>
                <textarea 
                    id="ringkasan" 
                    name="ringkasan" 
                    class="input-clean" 
                    rows="3" 
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
                    required
                ><?= htmlspecialchars($isi) ?></textarea>
                <div class="field-hint">
                    <span id="wordCount">0 kata</span>
                    <span id="readTimeEst">&plusmn; 1 menit baca</span>
                </div>
            </div>

            <div class="btn-row">
                <a href="baca.php?id=<?= $id ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
