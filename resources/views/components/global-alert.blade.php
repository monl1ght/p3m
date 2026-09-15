@php
    $p3mFlash = null;
    if (session('success')) {
        $p3mFlash = ['type' => 'success', 'title' => 'Berhasil', 'message' => session('success')];
    } elseif (session('status')) {
        $p3mFlash = ['type' => 'success', 'title' => 'Berhasil', 'message' => session('status')];
    } elseif (session('error')) {
        $p3mFlash = ['type' => 'error', 'title' => 'Gagal', 'message' => session('error')];
    } elseif (session('warning')) {
        $p3mFlash = ['type' => 'warning', 'title' => 'Perhatian', 'message' => session('warning')];
    } elseif (session('info')) {
        $p3mFlash = ['type' => 'info', 'title' => 'Informasi', 'message' => session('info')];
    } elseif (isset($errors) && $errors->any() && !session('form_context')) {
        $p3mFlash = ['type' => 'error', 'title' => 'Gagal', 'message' => $errors->first()];
    }
@endphp

@if ($p3mFlash)
<div id="p3m-flash-data" style="display:none;"
     data-type="{{ $p3mFlash['type'] }}"
     data-title="{{ $p3mFlash['title'] }}"
     data-message="{{ $p3mFlash['message'] }}"
     data-id="{{ uniqid('p3m_flash_') }}"></div>
@endif

<script>
/* Fallback SweetAlert2 loader if not present */
if (typeof window.Swal === 'undefined') {
    var swalScript = document.createElement('script');
    swalScript.src = "{{ asset('lte/plugins/sweetalert2/sweetalert2.all.min.js') }}";
    swalScript.onerror = function() {
        var fallback = document.createElement('script');
        fallback.src = "https://cdn.jsdelivr.net/npm/sweetalert2@11";
        document.head.appendChild(fallback);
    };
    document.head.appendChild(swalScript);
}
</script>

<style>
/* =====================================================================
   P3M — Clean Floating-Disc Modal System (Global Professional)
   Konsep: Big Hero Floating Disc, Minimalist Text & Pill Buttons
   ===================================================================== */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap');

/* ── 0. Suppress legacy inline alert boxes ── */
.alert-p3m,
.alert.alert-p3m {
    display: none !important;
}

/* ── 1. Frosted Backdrop ── */
.swal2-container.swal2-backdrop-show {
    background: rgba(10, 25, 20, 0.45) !important;
    backdrop-filter: blur(8px) !important;
    -webkit-backdrop-filter: blur(8px) !important;
}

/* ── 2. White Card Container ── */
.p3m-swal-popup,
.swal2-popup.p3m-swal-popup,
div:where(.swal2-container) div:where(.swal2-popup) {
    border-radius: 28px !important;
    padding: 36px 26px 28px !important;
    box-shadow: 0 24px 50px rgba(0, 0, 0, 0.12), 0 2px 6px rgba(0, 0, 0, 0.04) !important;
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    border: none !important;
    width: 320px !important;
    max-width: 92vw !important;
    background: #ffffff !important;
    overflow: visible !important;
    text-align: center !important;
}

/* ── 3. Big Hero Floating Disc Icon ── */
div:where(.swal2-container) .swal2-icon {
    width: 96px !important;
    height: 96px !important;
    border-radius: 50% !important;
    background: #ffffff !important;
    border: none !important;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.12), 0 3px 8px rgba(0, 0, 0, 0.04) !important;
    margin: 0 auto 18px auto !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    overflow: visible !important;
    animation: p3mDiscPop 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
}

@keyframes p3mDiscPop {
    0% { transform: scale(0.65); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

div:where(.swal2-container) .swal2-icon .swal2-icon-content {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    height: 100% !important;
}

/* Hide default SweetAlert animation lines */
div:where(.swal2-container) .swal2-icon .swal2-success-ring,
div:where(.swal2-container) .swal2-icon [class^="swal2-success-line"],
div:where(.swal2-container) .swal2-icon [class^="swal2-x-mark"] {
    display: none !important;
}

/* ── 4. Compact Minimalist Typography ── */
div:where(.swal2-container) .swal2-title {
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    font-size: 16.5px !important;
    font-weight: 700 !important;
    color: #1e293b !important;
    letter-spacing: -0.015em !important;
    line-height: 1.3 !important;
    padding: 0 !important;
    margin: 0 0 6px 0 !important;
}

div:where(.swal2-container) .swal2-html-container {
    font-size: 12px !important;
    color: #8c9ba5 !important;
    line-height: 1.55 !important;
    margin: 0 !important;
    padding: 0 6px !important;
    font-weight: 500 !important;
}

div:where(.swal2-container) .swal2-html-container strong {
    color: #0f172a !important;
    font-weight: 700 !important;
}

/* ── 5. Action Buttons (Pill-shaped with Glow Shadow) ── */
div:where(.swal2-container) .swal2-actions {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    width: 100% !important;
    margin: 22px 0 0 0 !important;
    padding: 0 !important;
    flex-wrap: nowrap !important;
}

div:where(.swal2-container) .swal2-actions button:not([style*="display: none"]) {
    flex: 1 1 0 !important;
    height: 40px !important;
    min-height: 40px !important;
    margin: 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 0 14px !important;
    border-radius: 9999px !important; /* Full Pill */
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    font-size: 11.5px !important;
    font-weight: 700 !important;
    letter-spacing: 0.05em !important;
    text-transform: uppercase !important;
    cursor: pointer !important;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    outline: none !important;
    box-sizing: border-box !important;
    border: none !important;
    white-space: nowrap !important;
}

/* Explicitly hide hidden buttons */
div:where(.swal2-container) .swal2-actions button[style*="display: none"],
div:where(.swal2-container) .swal2-actions button[aria-hidden="true"],
div:where(.swal2-container) .swal2-deny:not([style*="display: inline-block"]):not([style*="display: flex"]):not([style*="display: block"]) {
    display: none !important;
}

div:where(.swal2-container) .swal2-actions button:focus {
    outline: none !important;
    box-shadow: none !important;
}

/* Cancel Button — Soft Gray Pill */
div:where(.swal2-container) button.swal2-cancel,
div:where(.swal2-container) button.swal-btn-cancel,
div:where(.swal2-container) button.p3m-swal-btn-cancel {
    background: #f1f5f9 !important;
    color: #64748b !important;
}
div:where(.swal2-container) button.swal2-cancel:hover,
div:where(.swal2-container) button.swal-btn-cancel:hover,
div:where(.swal2-container) button.p3m-swal-btn-cancel:hover {
    background: #e2e8f0 !important;
    color: #1e293b !important;
    transform: translateY(-1px) !important;
}

/* Danger / Delete Button — Crimson Red Pill with Glow Shadow */
div:where(.swal2-container) button.swal-btn-danger,
div:where(.swal2-container) button.p3m-swal-btn-danger {
    background: #e11d48 !important;
    color: #ffffff !important;
    box-shadow: 0 8px 18px rgba(225, 29, 72, 0.35) !important;
}
div:where(.swal2-container) button.swal-btn-danger:hover,
div:where(.swal2-container) button.p3m-swal-btn-danger:hover {
    background: #be123c !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 10px 22px rgba(225, 29, 72, 0.45) !important;
}

/* Success Button — Green Pill with Glow Shadow */
div:where(.swal2-container) button.swal2-confirm:not(.swal-btn-danger):not(.p3m-swal-btn-danger):not(.p3m-swal-btn-warning),
div:where(.swal2-container) button.p3m-swal-btn-primary {
    background: #16a34a !important;
    color: #ffffff !important;
    box-shadow: 0 8px 18px rgba(22, 163, 74, 0.35) !important;
}
div:where(.swal2-container) button.swal2-confirm:not(.swal-btn-danger):not(.p3m-swal-btn-danger):not(.p3m-swal-btn-warning):hover,
div:where(.swal2-container) button.p3m-swal-btn-primary:hover {
    background: #15803d !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 10px 22px rgba(22, 163, 74, 0.45) !important;
}

/* Warning Button — Amber Pill with Glow Shadow */
div:where(.swal2-container) button.p3m-swal-btn-warning {
    background: #d97706 !important;
    color: #ffffff !important;
    box-shadow: 0 8px 18px rgba(217, 119, 6, 0.35) !important;
}
div:where(.swal2-container) button.p3m-swal-btn-warning:hover {
    background: #b45309 !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 10px 22px rgba(217, 119, 6, 0.45) !important;
}

/* Timer progress bar */
div:where(.swal2-container) .swal2-timer-progress-bar {
    background: #16a34a !important;
    height: 3px !important;
    border-radius: 0 0 28px 28px !important;
}
div:where(.swal2-container) .p3m-theme-danger .swal2-timer-progress-bar {
    background: #e11d48 !important;
}
</style>

<script>
/**
 * P3M Global Clean Floating-Disc SweetAlert2 System
 * Supports: Turbo Drive, SPA Body swaps, Traditional Page Loads, Confirmation Popups
 */
(function() {
    'use strict';

    /* Floating Disc Icons (Large Hero Vector SVGs & Icons) */
    var DISCS = {
        // Success: Large Green Checkmark
        success: '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                 '  <path d="M11 25L20 34L37 16" stroke="#16a34a" stroke-width="5.5" stroke-linecap="round" stroke-linejoin="round"/>' +
                 '</svg>',

        // Failure / Error: Large Red Cross
        error: '<svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">' +
               '  <path d="M12 12L32 32M32 12L12 32" stroke="#e11d48" stroke-width="5" stroke-linecap="round"/>' +
               '</svg>',

        // Delete / Trash: Large Crimson Trash Icon
        delete: '<i class="fas fa-trash-alt" style="font-size: 38px; color: #e11d48;"></i>',

        // Warning: Large Amber Exclamation Mark
        warning: '<svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                 '  <path d="M22 10V25M22 34H22.02" stroke="#d97706" stroke-width="5" stroke-linecap="round"/>' +
                 '</svg>',

        // Save / Info: Clean Blue Bookmark / Check
        save: '<svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">' +
              '  <path d="M14 8H30C32.2 8 34 9.8 34 12V36L22 30L10 36V12C10 9.8 11.8 8 14 8Z" stroke="#16a34a" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>' +
              '</svg>'
    };

    /**
     * Resilient Polling: Run callback only when SweetAlert2 is fully available
     */
    function executeWhenSwalReady(callback) {
        if (typeof window.Swal === 'function') {
            callback();
            return;
        }
        var attempts = 0;
        var interval = setInterval(function() {
            attempts++;
            if (typeof window.Swal === 'function') {
                clearInterval(interval);
                callback();
            } else if (attempts > 80) { // 4 seconds max
                clearInterval(interval);
                console.warn('P3M: SweetAlert2 not ready within 4s timeout.');
            }
        }, 50);
    }

    /**
     * Tampilkan popup flash alert
     */
    function showFlash(type, title, text, timer, buttonText) {
        executeWhenSwalReady(function() {
            var iconHtml = DISCS[type] || DISCS.success;
            var defaultTitle = (type === 'success' ? 'Berhasil' : (type === 'error' ? 'Gagal' : 'Perhatian'));

            var cfg = {
                title: title || defaultTitle,
                html: text,
                icon: 'info',
                iconHtml: iconHtml,
                customClass: {
                    popup: 'p3m-swal-popup'
                },
                showConfirmButton: false,
                timer: timer !== undefined ? timer : 3500,
                timerProgressBar: true,
            };

            if (type === 'error') {
                cfg.showConfirmButton = true;
                cfg.confirmButtonText = buttonText || 'COBA LAGI';
                cfg.customClass.confirmButton = 'p3m-swal-btn-danger';
                cfg.buttonsStyling = false;
                cfg.timer = null;
                cfg.timerProgressBar = false;
            } else if (type === 'warning') {
                cfg.showConfirmButton = true;
                cfg.confirmButtonText = buttonText || 'MENGERTI';
                cfg.customClass.confirmButton = 'p3m-swal-btn-warning';
                cfg.buttonsStyling = false;
            } else if (type === 'success') {
                cfg.showConfirmButton = true;
                cfg.confirmButtonText = buttonText || 'OK';
                cfg.customClass.confirmButton = 'p3m-swal-btn-primary';
                cfg.buttonsStyling = false;
            }

            window.Swal.fire(cfg);
        });
    }

    /**
     * Global Flash Check from DOM marker
     */
    window._p3mProcessedFlashIds = window._p3mProcessedFlashIds || {};

    function checkAndShowFlash() {
        var el = document.getElementById('p3m-flash-data');
        if (!el) return;

        var flashId = el.getAttribute('data-id');
        if (!flashId || window._p3mProcessedFlashIds[flashId]) return;
        window._p3mProcessedFlashIds[flashId] = true;

        var type = el.getAttribute('data-type') || 'success';
        var title = el.getAttribute('data-title') || 'Berhasil';
        var message = el.getAttribute('data-message') || '';

        // Clean up leftover Bootstrap modal backdrops and reset body classes
        try {
            var backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(function(b) { b.remove(); });
            document.body.classList.remove('modal-open');
            document.body.style.paddingRight = '';
        } catch(e) {}

        var timer = (type === 'error' ? null : (type === 'warning' ? 4500 : 3500));
        showFlash(type, title, message, timer);
    }

    /**
     * Global APIs on window object
     */
    window.p3mAlert = function(type, message, title, timer, buttonText) {
        showFlash(type, title, message, timer, buttonText);
    };
    window.p3mSuccess = function(message, title, timer, buttonText) {
        showFlash('success', title || 'Berhasil', message, timer || 3500, buttonText);
    };
    window.p3mError = function(message, title, buttonText) {
        showFlash('error', title || 'Gagal', message, null, buttonText);
    };
    window.p3mWarning = function(message, title, timer) {
        showFlash('warning', title || 'Perhatian', message, timer || 4500);
    };
    window.p3mInfo = function(message, title, timer) {
        showFlash('info', title || 'Informasi', message, timer || 3500);
    };

    /**
     * Popup konfirmasi aksi umum
     */
    window.p3mConfirm = function(opts) {
        executeWhenSwalReady(function() {
            var isDanger = opts.confirmClass && opts.confirmClass.indexOf('danger') !== -1;
            var iconHtml = opts.iconHtml || (isDanger ? DISCS.delete : (opts.icon === 'save' ? DISCS.save : DISCS.warning));

            window.Swal.fire({
                title: opts.title || 'Konfirmasi',
                html: opts.html || 'Lanjutkan tindakan ini?',
                icon: 'info',
                iconHtml: iconHtml,
                showCancelButton: true,
                confirmButtonText: opts.confirmText || 'Lanjutkan',
                cancelButtonText: opts.cancelButtonText || 'Batal',
                customClass: {
                    popup: 'p3m-swal-popup',
                    confirmButton: opts.confirmClass || 'p3m-swal-btn-primary',
                    cancelButton: 'p3m-swal-btn-cancel',
                },
                buttonsStyling: false,
                reverseButtons: true,
                focusCancel: true,
            }).then(function(result) {
                if (result.isConfirmed) {
                    opts.onConfirm && opts.onConfirm();
                }
            });
        });
    };

    /**
     * Konfirmasi Hapus Data (Clean Floating Disc & Pill Buttons)
     */
    window.p3mDelete = function(btn) {
        executeWhenSwalReady(function() {
            var label = btn.dataset.label || (btn.getAttribute('title') ? btn.getAttribute('title').replace(/^Hapus\s*/i, '') : 'item ini');
            var type  = btn.dataset.type || 'Data';
            var url   = btn.dataset.url || null;
            var formId = btn.dataset.formId || null;
            var formEl = btn.closest ? btn.closest('form') : null;

            window.Swal.fire({
                title: 'Hapus ' + type,
                html: 'Data <strong>' + label + '</strong> akan dihapus permanen.<br>Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                iconHtml: DISCS.delete,
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'p3m-swal-popup',
                    confirmButton: 'p3m-swal-btn-danger',
                    cancelButton: 'p3m-swal-btn-cancel',
                },
                buttonsStyling: false,
                reverseButtons: true,
                focusCancel: true,
            }).then(function(result) {
                if (result.isConfirmed) {
                    if (url) {
                        var gf = document.getElementById('global-delete-form');
                        if (gf) { gf.action = url; gf.submit(); return; }
                    }
                    if (formId) {
                        var f = document.getElementById(formId);
                        if (f) { f.submit(); return; }
                    }
                    if (formEl) { formEl.submit(); }
                }
            });
        });
    };

    /**
     * Popup konfirmasi approve
     */
    window.p3mApprove = function(btn) {
        executeWhenSwalReady(function() {
            var label = btn.dataset.label || 'pengajuan ini';
            var type = btn.dataset.type || 'Usulan';
            var title = btn.dataset.title || ('Setujui ' + type);
            var formId = btn.dataset.formId || null;
            var formEl = formId ? document.getElementById(formId) : (btn.closest ? btn.closest('form') : null);

            window.Swal.fire({
                title: title,
                html: type + ' <strong>' + label + '</strong> akan disahkan secara resmi di sistem.',
                icon: 'success',
                iconHtml: DISCS.success,
                showCancelButton: true,
                confirmButtonText: 'Setujui',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'p3m-swal-popup',
                    confirmButton: 'p3m-swal-btn-primary',
                    cancelButton: 'p3m-swal-btn-cancel',
                },
                buttonsStyling: false,
                reverseButtons: true,
                focusCancel: true,
            }).then(function(result) {
                if (result.isConfirmed && formEl) {
                    formEl.submit();
                }
            });
        });
    };

    /**
     * Popup konfirmasi set proses
     */
    window.p3mSetProses = function(btn) {
        executeWhenSwalReady(function() {
            var label = btn.dataset.label || 'pengajuan ini';
            var type = btn.dataset.type || 'Usulan';
            var title = btn.dataset.title || ('Set ' + type + ' Diproses');
            var formId = btn.dataset.formId || null;
            var formEl = formId ? document.getElementById(formId) : (btn.closest ? btn.closest('form') : null);

            window.Swal.fire({
                title: title,
                html: type + ' <strong>' + label + '</strong> akan ditandai sedang ditinjau P3M.',
                icon: 'info',
                iconHtml: DISCS.warning,
                showCancelButton: true,
                confirmButtonText: 'Set Diproses',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'p3m-swal-popup',
                    confirmButton: 'p3m-swal-btn-warning',
                    cancelButton: 'p3m-swal-btn-cancel',
                },
                buttonsStyling: false,
                reverseButtons: true,
                focusCancel: true,
            }).then(function(result) {
                if (result.isConfirmed && formEl) {
                    formEl.submit();
                }
            });
        });
    };

    /**
     * Intercept and bind action triggers (Delete, Confirm, Approve, Proses)
     */
    function bindP3mActions() {
        // 1. Delete triggers
        document.querySelectorAll('[data-p3m-delete]').forEach(function(btn) {
            if (btn._p3mBound) return;
            btn._p3mBound = true;
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                window.p3mDelete(btn);
            });
        });

        // 2. Generic Confirmation (Save, Submit, Action)
        document.querySelectorAll('[data-p3m-confirm]').forEach(function(btn) {
            if (btn._p3mBound) return;
            btn._p3mBound = true;
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var msg = btn.dataset.p3mConfirm || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
                var title = btn.dataset.confirmTitle || 'Konfirmasi Simpan';
                var confirmText = btn.dataset.confirmText || 'Ya, Simpan';
                var form = btn.closest ? btn.closest('form') : null;

                window.Swal.fire({
                    title: title,
                    html: msg,
                    icon: 'info',
                    iconHtml: DISCS.save,
                    showCancelButton: true,
                    confirmButtonText: confirmText,
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'p3m-swal-popup',
                        confirmButton: 'p3m-swal-btn-primary',
                        cancelButton: 'p3m-swal-btn-cancel',
                    },
                    buttonsStyling: false,
                    reverseButtons: true,
                    focusCancel: true,
                }).then(function(result) {
                    if (result.isConfirmed) {
                        if (btn.type === 'submit' && form) {
                            form.submit();
                        } else if (btn.tagName === 'A' && btn.href) {
                            window.location.href = btn.href;
                        }
                    }
                });
            });
        });

        // 3. Approve triggers
        document.querySelectorAll('[data-p3m-approve]').forEach(function(btn) {
            if (btn._p3mBound) return;
            btn._p3mBound = true;
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                window.p3mApprove(btn);
            });
        });

        // 4. Proses triggers
        document.querySelectorAll('[data-p3m-proses]').forEach(function(btn) {
            if (btn._p3mBound) return;
            btn._p3mBound = true;
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                window.p3mSetProses(btn);
            });
        });
    }

    /**
     * Life cycle listeners for instant Turbo, DOMContentLoaded, and Turbo visits
     */
    window.p3mBindActions = bindP3mActions;

    function init() {
        checkAndShowFlash();
        bindP3mActions();
    }

    // 1. Immediate call if DOM is already ready (e.g. Turbo body swaps)
    if (document.readyState === 'interactive' || document.readyState === 'complete') {
        init();
    }

    // 2. Standard page load
    document.addEventListener('DOMContentLoaded', init);

    // 3. Turbo Drive transitions
    document.addEventListener('turbo:load', init);
    document.addEventListener('turbo:render', init);
})();
</script>
