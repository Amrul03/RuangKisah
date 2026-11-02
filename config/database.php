<?php
// config/database.php
// Konfigurasi koneksi database MySQL menggunakan PDO

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'db_cerpen';

try {
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    // Tampilan ramah pengguna jika database belum diimport di phpMyAdmin
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Database Belum Siap | RuangKisah</title>
        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
            body { background: #0f172a; color: #f8fafc; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
            .error-card { background: #1e293b; border: 1px solid #334155; border-radius: 16px; padding: 32px; max-width: 600px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.4); text-align: center; }
            .icon { font-size: 50px; margin-bottom: 16px; }
            h2 { color: #f43f5e; margin-bottom: 12px; font-size: 24px; }
            p { color: #94a3b8; line-height: 1.6; margin-bottom: 20px; font-size: 15px; }
            .steps { background: #0b1120; border-radius: 10px; padding: 16px; text-align: left; margin-bottom: 24px; font-size: 14px; border: 1px solid #1e293b; }
            .steps ol { padding-left: 20px; color: #cbd5e1; }
            .steps li { margin-bottom: 8px; }
            .code { background: #1e293b; color: #38bdf8; padding: 2px 6px; border-radius: 4px; font-family: monospace; }
            .btn-refresh { display: inline-block; background: #6366f1; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: 0.2s; }
            .btn-refresh:hover { background: #4f46e5; }
        </style>
    </head>
    <body>
        <div class="error-card">
            <div class="icon">⚠️</div>
            <h2>Gagal Terhubung ke Database!</h2>
            <p>Database <span class="code">db_cerpen</span> belum ditemukan atau Laragon MySQL belum dinyalakan.</p>
            <div class="steps">
                <strong>Langkah Mudah Mengatasi:</strong>
                <ol>
                    <li>Buka <strong>Laragon</strong> lalu klik tombol <strong>Start All</strong>.</li>
                    <li>Buka <strong>phpMyAdmin</strong> di browser (<span class="code">http://localhost/phpmyadmin</span>).</li>
                    <li>Buat database baru dengan nama <strong>db_cerpen</strong> (atau klik menu <em>Import</em>).</li>
                    <li>Pilih file <span class="code">database.sql</span> yang ada di dalam folder project ini, lalu klik <strong>Import / Kirim</strong>.</li>
                </ol>
            </div>
            <p style="font-size: 13px; color: #64748b;">Pesan Error Teknis: <?= htmlspecialchars($e->getMessage()) ?></p>
            <a href="index.php" class="btn-refresh">🔄 Coba Refresh Halaman</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}
