<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' — RuangKisah' : 'RuangKisah' ?></title>
    <meta name="description" content="Platform minimalis untuk membaca, menulis, dan mengelola cerita pendek karya penulis.">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Apple-style Minimal Navbar -->
    <header class="navbar">
        <div class="container nav-wrapper">
            <a href="index.php" class="brand-logo">
                <span class="brand-dot"></span>
                <span class="brand-name">Ruang<span>Kisah</span></span>
            </a>

            <div class="nav-actions">
                <a href="index.php" class="btn btn-secondary btn-sm">Jelajah</a>
                <a href="tambah.php" class="btn btn-primary btn-sm">+ Tulis</a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="container">
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="toast-alert toast-<?= htmlspecialchars($_SESSION['flash_type'] ?? 'success') ?>">
                <span><?= htmlspecialchars($_SESSION['flash_message']) ?></span>
                <button type="button" class="toast-close">&times;</button>
            </div>
            <?php 
                unset($_SESSION['flash_message']);
                unset($_SESSION['flash_type']);
            ?>
        <?php endif; ?>
