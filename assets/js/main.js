// assets/js/main.js
// Minimalist interactions for RuangKisah

document.addEventListener('DOMContentLoaded', () => {
    initDeleteModal();
    initStoryWordCounter();
    initReaderControls();
    initToastAlerts();
    initLiveSearchFilter();
});

/* Modal Konfirmasi Hapus */
function initDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (!modal) return;

    const modalTitle = document.getElementById('deleteModalTitle');
    const confirmBtn = document.getElementById('deleteConfirmBtn');
    const cancelBtn = document.getElementById('deleteCancelBtn');
    const deleteTriggers = document.querySelectorAll('.js-delete-trigger');

    deleteTriggers.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const id = btn.getAttribute('data-id');
            const title = btn.getAttribute('data-title');
            
            if (modalTitle) {
                modalTitle.textContent = `"${title}"`;
            }
            if (confirmBtn) {
                confirmBtn.href = `hapus.php?id=${id}`;
            }

            modal.classList.add('active');
        });
    });

    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            modal.classList.remove('active');
        });
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });
}

/* Penghitung Kata & Estimasi Waktu */
function initStoryWordCounter() {
    const textarea = document.getElementById('isiCerpen');
    const wordCountEl = document.getElementById('wordCount');
    const readTimeEl = document.getElementById('readTimeEst');

    if (textarea && wordCountEl) {
        const updateCounts = () => {
            const text = textarea.value.trim();
            const words = text ? text.split(/\s+/).length : 0;
            const minutes = Math.ceil(words / 180);

            wordCountEl.textContent = `${words} kata`;
            if (readTimeEl) {
                readTimeEl.textContent = `± ${minutes} menit baca`;
            }
        };

        textarea.addEventListener('input', updateCounts);
        updateCounts();
    }
}

/* Pengatur Ukuran Font Reader */
function initReaderControls() {
    const content = document.querySelector('.story-content');
    const btnSmaller = document.getElementById('fontSmaller');
    const btnReset = document.getElementById('fontReset');
    const btnLarger = document.getElementById('fontLarger');

    if (!content) return;

    let currentSize = 18;

    if (btnSmaller) {
        btnSmaller.addEventListener('click', () => {
            if (currentSize > 15) {
                currentSize -= 1.5;
                content.style.fontSize = `${currentSize}px`;
            }
        });
    }

    if (btnReset) {
        btnReset.addEventListener('click', () => {
            currentSize = 18;
            content.style.fontSize = `${currentSize}px`;
        });
    }

    if (btnLarger) {
        btnLarger.addEventListener('click', () => {
            if (currentSize < 24) {
                currentSize += 1.5;
                content.style.fontSize = `${currentSize}px`;
            }
        });
    }
}

/* Auto-dismiss Toast Alert */
function initToastAlerts() {
    const alerts = document.querySelectorAll('.toast-alert');
    alerts.forEach(alert => {
        const closeBtn = alert.querySelector('.toast-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                alert.style.display = 'none';
            });
        }

        setTimeout(() => {
            alert.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-6px)';
            setTimeout(() => alert.remove(), 400);
        }, 4000);
    });
}

/* Live Search Filter */
function initLiveSearchFilter() {
    const searchInput = document.getElementById('liveSearchInput');
    const items = document.querySelectorAll('.story-item, .story-card');
    const emptyState = document.getElementById('emptyStateSearch');

    if (!searchInput || !items.length) return;

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        let matchCount = 0;

        items.forEach(item => {
            const title = (item.querySelector('.story-title, .card-title')?.textContent || '').toLowerCase();
            const author = (item.querySelector('.story-author, .author-name')?.textContent || '').toLowerCase();
            const synopsis = (item.querySelector('.story-synopsis, .card-excerpt')?.textContent || '').toLowerCase();
            const badge = (item.querySelector('.story-badge, .category-badge')?.textContent || '').toLowerCase();

            if (title.includes(query) || author.includes(query) || synopsis.includes(query) || badge.includes(query)) {
                item.style.display = 'flex';
                matchCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (emptyState) {
            emptyState.style.display = (matchCount === 0) ? 'block' : 'none';
        }
    });
}
