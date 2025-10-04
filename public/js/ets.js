/**
 * Validasi form input bahan baku (create/edit)
 * Highlight field kosong dengan border merah
 */
function setupBahanValidation() {
    const fields = ['nama', 'kategori', 'jumlah', 'satuan', 'tanggal_masuk', 'tanggal_kadaluarsa'];
    fields.forEach(fieldId => {
        const input = document.getElementById(fieldId);
        if (!input) return;

        // Validasi saat input berubah
        input.addEventListener('input', function () {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });

        // Validasi saat form disubmit (fallback)
        input.form?.addEventListener('submit', function () {
            if (input.value.trim() === '') {
                input.classList.add('is-invalid');
            }
        });
    });
}

/**
 * Highlight menu aktif di navbar berdasarkan URL
 */

function setActiveNav() {
    const path = window.location.pathname;

    // GUDANG
    if (path.startsWith('/gudang')) {
        const buttons = [
            { selector: 'a[href*="/gudang/bahan"]', paths: ['/gudang/bahan'] },
            { selector: 'a[href*="/gudang/permintaan"]', paths: ['/gudang/permintaan'] }
        ];

        buttons.forEach(item => {
            const el = document.querySelector(item.selector);
            if (!el) return;

            const isActive = item.paths.some(p => path.startsWith(p));
            if (isActive) {
                el.classList.remove('btn-outline-light');
                el.classList.add('btn-primary', 'active');
                el.style.fontWeight = 'bold';
            } else {
                el.classList.remove('btn-primary', 'active');
                el.classList.add('btn-outline-light');
                el.style.fontWeight = '';
            }
        });
    }

    // DAPUR
    if (path.startsWith('/dapur')) {
        const buttons = [
            { selector: 'a[href*="/dapur/permintaan"]', paths: ['/dapur/permintaan'] },
            { selector: 'a[href*="/dapur/status"]', paths: ['/dapur/status'] }
        ];

        buttons.forEach(item => {
            const el = document.querySelector(item.selector);
            if (!el) return;

            const isActive = item.paths.some(p => path.startsWith(p));
            if (isActive) {
                el.classList.remove('btn-outline-light');
                el.classList.add('btn-success', 'active');
                el.style.fontWeight = 'bold';
            } else {
                el.classList.remove('btn-success', 'active');
                el.classList.add('btn-outline-light');
                el.style.fontWeight = '';
            }
        });
    }
}

// /**
//  * Setup konfirmasi hapus 
//  */
// function setupDeleteConfirmation() {
//     document.addEventListener('click', function (e) {
//         if (e.target.closest('.btn-danger') && e.target.closest('[data-confirm]')) {
//             const message = e.target.closest('[data-confirm]').dataset.confirm || 'Yakin ingin menghapus data ini?';
//             if (!confirm(message)) {
//                 e.preventDefault();
//             }
//         }
//     });
// }

// ================================
// INIT
// ================================

document.addEventListener('DOMContentLoaded', function () {
    setupBahanValidation();
    setActiveNav();
    setupDeleteConfirmation();
});