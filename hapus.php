<?php
// hapus.php (DELETE)
require_once 'config/database.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['flash_message'] = 'ID cerpen tidak valid.';
    $_SESSION['flash_type'] = 'error';
    header('Location: index.php');
    exit;
}

try {
    // Ambil judul untuk pesan feedback
    $checkStmt = $pdo->prepare("SELECT judul FROM cerpen WHERE id = :id");
    $checkStmt->execute([':id' => $id]);
    $story = $checkStmt->fetch();

    if ($story) {
        $deleteStmt = $pdo->prepare("DELETE FROM cerpen WHERE id = :id");
        $deleteStmt->execute([':id' => $id]);

        $_SESSION['flash_message'] = "Cerpen \"{$story['judul']}\" berhasil dihapus.";
        $_SESSION['flash_type'] = 'success';
    } else {
        $_SESSION['flash_message'] = 'Cerpen tidak ditemukan atau sudah dihapus sebelumnya.';
        $_SESSION['flash_type'] = 'error';
    }
} catch (PDOException $e) {
    $_SESSION['flash_message'] = 'Gagal menghapus cerpen: ' . $e->getMessage();
    $_SESSION['flash_type'] = 'error';
}

header('Location: index.php');
exit;
