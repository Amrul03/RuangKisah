<?php
// includes/footer.php
?>
    </main>

    <!-- Modal Konfirmasi Hapus Cerpen Minimalis -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-box">
            <h3 class="modal-title">Hapus Cerita?</h3>
            <p class="modal-desc">
                Apakah Anda yakin ingin menghapus cerpen <strong id="deleteModalTitle" style="color: var(--text-white);"></strong>? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="modal-actions">
                <button type="button" id="deleteCancelBtn" class="btn btn-secondary btn-sm">Batal</button>
                <a id="deleteConfirmBtn" href="#" class="btn btn-outline-danger btn-sm">Hapus</a>
            </div>
        </div>
    </div>

    <!-- Apple-style Minimal Footer -->
    <footer class="site-footer">
        <div class="container footer-content">
            <div>
                &copy; <?= date('Y') ?> RuangKisah. Dibuat dengan PHP Native &amp; MySQL.
            </div>
            <div class="footer-links">
                <a href="index.php">Koleksi</a>
                <a href="tambah.php">Tulis Baru</a>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
