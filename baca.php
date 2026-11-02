<?php
// baca.php (READ DETAIL)
require_once 'config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['flash_message'] = 'ID cerpen tidak valid.';
    $_SESSION['flash_type'] = 'error';
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM cerpen WHERE id = :id");
$stmt->execute([':id' => $id]);
$story = $stmt->fetch();

if (!$story) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['flash_message'] = 'Cerpen tidak ditemukan.';
    $_SESSION['flash_type'] = 'error';
    header('Location: index.php');
    exit;
}

// Tambah views (+1)
$updateViews = $pdo->prepare("UPDATE cerpen SET views = views + 1 WHERE id = :id");
$updateViews->execute([':id' => $id]);
$story['views'] += 1;

$pageTitle = $story['judul'];
$wordCount = str_word_count(strip_tags($story['isi']));
$estTime = max(1, ceil($wordCount / 180));
$paragraphs = array_filter(array_map('trim', explode("\n", $story['isi'])));

require_once 'includes/header.php';
?>

<div class="reader-container">
    <a href="index.php" class="reader-nav-back">
        <span>← Kembali ke Koleksi Cerita</span>
    </a>

    <article>
        <header>
            <div class="reader-badge-wrap">
                <span class="story-badge"><?= htmlspecialchars($story['kategori']) ?></span>
            </div>

            <!-- TITLE HIGHLIGHTED -->
            <h1 class="reader-title-highlight"><?= htmlspecialchars($story['judul']) ?></h1>

            <div class="reader-meta-row">
                <div>
                    <strong><?= htmlspecialchars($story['penulis']) ?></strong>
                    <span style="margin-left: 6px; color: var(--text-muted);">&bull; <?= date('d F Y', strtotime($story['created_at'])) ?></span>
                </div>
                <div>
                    <span><?= number_format($wordCount) ?> kata</span> &bull; 
                    <span><?= $estTime ?> menit baca</span> &bull; 
                    <span><?= number_format($story['views']) ?> kali dibaca</span>
                </div>
            </div>

            <!-- Reading Font Resizer -->
            <div class="reader-controls-bar">
                <span style="font-size: 12px; color: var(--text-muted); margin-right: 4px;">Ukuran Teks:</span>
                <button type="button" id="fontSmaller" class="ctrl-btn" title="Kecilkan">A-</button>
                <button type="button" id="fontReset" class="ctrl-btn" title="Normal">A</button>
                <button type="button" id="fontLarger" class="ctrl-btn" title="Besarkan">A+</button>
            </div>
        </header>

        <!-- Story Content (Clean Apple Editorial serif) -->
        <div class="story-body story-content">
            <?php foreach ($paragraphs as $para): ?>
                <?php if (!empty($para)): ?>
                    <p><?= nl2br(htmlspecialchars($para)) ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Footer Actions -->
        <footer class="reader-footer">
            <a href="index.php" class="btn btn-secondary btn-sm">← Daftar Cerita</a>

            <div style="display: flex; gap: 8px;">
                <a href="edit.php?id=<?= $story['id'] ?>" class="btn btn-secondary btn-sm">Edit Cerita</a>
                <button 
                    type="button" 
                    class="btn btn-outline-danger btn-sm js-delete-trigger"
                    data-id="<?= $story['id'] ?>" 
                    data-title="<?= htmlspecialchars($story['judul']) ?>">
                    Hapus
                </button>
            </div>
        </footer>
    </article>
</div>

<?php require_once 'includes/footer.php'; ?>
