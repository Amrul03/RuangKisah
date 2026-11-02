<?php
// index.php
require_once 'config/database.php';

$pageTitle = 'Koleksi Cerita';

// Parameter Filter & Search
$search = trim($_GET['search'] ?? '');
$kategori = trim($_GET['kategori'] ?? '');
$sort = trim($_GET['sort'] ?? 'terbaru');

// Susun Query SQL
$sql = "SELECT * FROM cerpen WHERE 1=1";
$params = [];

if (!empty($search)) {
    $sql .= " AND (judul LIKE :search OR penulis LIKE :search OR ringkasan LIKE :search)";
    $params[':search'] = "%{$search}%";
}

if (!empty($kategori) && $kategori !== 'Semua') {
    $sql .= " AND kategori = :kategori";
    $params[':kategori'] = $kategori;
}

switch ($sort) {
    case 'terpopuler':
        $sql .= " ORDER BY views DESC, id DESC";
        break;
    case 'abjad':
        $sql .= " ORDER BY judul ASC";
        break;
    case 'terlama':
        $sql .= " ORDER BY id ASC";
        break;
    case 'terbaru':
    default:
        $sql .= " ORDER BY id DESC";
        break;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$cerpenList = $stmt->fetchAll();

// Statistik
$statsQuery = $pdo->query("SELECT COUNT(*) AS total_cerpen, COUNT(DISTINCT penulis) AS total_penulis, COALESCE(SUM(views), 0) AS total_views FROM cerpen");
$stats = $statsQuery->fetch();

$categories = ['Semua', 'Romantis', 'Horor', 'Fantasi', 'Komedi', 'Drama', 'Misteri', 'Sci-Fi'];

require_once 'includes/header.php';
?>

<!-- Minimal Hero Section -->
<section class="hero-section">
    <div class="hero-tagline">Ruang Karya Sastra Digital</div>
    <h1 class="hero-title">
        Kumpulan Kisah <span class="highlight-text">&amp; Catatan Rasa</span>
    </h1>
    <p class="hero-desc">
        Tempat menuangkan ide dan menikmati cerita pendek dalam balutan desain minimalis yang tenang dan elegan.
    </p>

    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="stat-item">
            <span class="stat-num"><?= number_format($stats['total_cerpen'] ?? 0) ?></span>
            <span class="stat-label">Cerpen Terbit</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-num"><?= number_format($stats['total_penulis'] ?? 0) ?></span>
            <span class="stat-label">Penulis</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-num"><?= number_format($stats['total_views'] ?? 0) ?></span>
            <span class="stat-label">Total Pembaca</span>
        </div>
    </div>
</section>

<!-- Filter & Search Controls -->
<section class="controls-wrapper">
    <form method="GET" action="index.php" class="search-row">
        <?php if (!empty($kategori)): ?>
            <input type="hidden" name="kategori" value="<?= htmlspecialchars($kategori) ?>">
        <?php endif; ?>

        <div class="search-box">
            <span class="search-icon">􀊫</span>
            <input 
                type="text" 
                id="liveSearchInput"
                name="search" 
                class="search-input" 
                placeholder="Cari judul, penulis, atau kata kunci cerita..." 
                value="<?= htmlspecialchars($search) ?>"
                autocomplete="off"
            >
        </div>

        <select name="sort" class="sort-select" onchange="this.form.submit()">
            <option value="terbaru" <?= $sort === 'terbaru' ? 'selected' : '' ?>>Terbaru</option>
            <option value="terpopuler" <?= $sort === 'terpopuler' ? 'selected' : '' ?>>Terpopuler</option>
            <option value="abjad" <?= $sort === 'abjad' ? 'selected' : '' ?>>Abjad (A-Z)</option>
            <option value="terlama" <?= $sort === 'terlama' ? 'selected' : '' ?>>Terlama</option>
        </select>

        <button type="submit" class="btn btn-secondary">Cari</button>
        <?php if (!empty($search) || (!empty($kategori) && $kategori !== 'Semua') || $sort !== 'terbaru'): ?>
            <a href="index.php" class="btn btn-secondary">Reset</a>
        <?php endif; ?>
    </form>

    <!-- Category Nav Pills -->
    <div class="category-nav">
        <?php foreach ($categories as $cat): ?>
            <?php 
                $isActive = ($kategori === $cat) || (empty($kategori) && $cat === 'Semua');
                $urlQuery = http_build_query([
                    'kategori' => $cat === 'Semua' ? '' : $cat,
                    'search'   => $search,
                    'sort'     => $sort
                ]);
            ?>
            <a href="index.php?<?= $urlQuery ?>" class="category-chip <?= $isActive ? 'active' : '' ?>">
                <?= htmlspecialchars($cat) ?>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Story List (Minimalist, Title Highlighted, No Photos) -->
<section class="stories-list">
    <?php if (empty($cerpenList)): ?>
        <div class="empty-state">
            <h3 class="empty-title">Tidak ada cerita ditemukan</h3>
            <p class="empty-desc">
                <?php if (!empty($search) || !empty($kategori)): ?>
                    Tidak ada cerpen yang cocok dengan kriteria pencarian Anda.
                <?php else: ?>
                    Belum ada cerpen yang diterbitkan di platform ini.
                <?php endif; ?>
            </p>
            <a href="tambah.php" class="btn btn-primary">Tulis Cerpen Baru</a>
        </div>
    <?php else: ?>
        <?php foreach ($cerpenList as $story): ?>
            <?php
                $wordCount = str_word_count(strip_tags($story['isi']));
                $estTime = max(1, ceil($wordCount / 180));
            ?>
            <article class="story-item">
                <div class="story-top-meta">
                    <span class="story-badge"><?= htmlspecialchars($story['kategori']) ?></span>
                    <span class="story-views"><?= number_format($story['views']) ?> pembaca &bull; <?= $estTime ?> min baca</span>
                </div>

                <!-- HIGHLIGHTED TITLE -->
                <h2 class="story-title">
                    <a href="baca.php?id=<?= $story['id'] ?>"><?= htmlspecialchars($story['judul']) ?></a>
                </h2>

                <p class="story-synopsis">
                    <?= htmlspecialchars($story['ringkasan']) ?>
                </p>

                <div class="story-bottom">
                    <div>
                        <span class="story-author"><?= htmlspecialchars($story['penulis']) ?></span>
                        <span class="story-date">&bull; <?= date('d M Y', strtotime($story['created_at'])) ?></span>
                    </div>

                    <div class="story-actions">
                        <a href="baca.php?id=<?= $story['id'] ?>" class="action-link">Baca</a>
                        <a href="edit.php?id=<?= $story['id'] ?>" class="action-link">Edit</a>
                        <button 
                            type="button" 
                            class="action-link danger js-delete-trigger" 
                            data-id="<?= $story['id'] ?>" 
                            data-title="<?= htmlspecialchars($story['judul']) ?>"
                            style="background: none; border: none; cursor: pointer;">
                            Hapus
                        </button>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Empty state for JS live search -->
    <div id="emptyStateSearch" class="empty-state" style="display: none;">
        <h3 class="empty-title">Tidak ada hasil</h3>
        <p class="empty-desc">Coba gunakan kata kunci pencarian yang lain.</p>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
