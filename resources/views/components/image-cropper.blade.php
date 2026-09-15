<div id="p3m-image-cropper-root" data-turbo-permanent>
{{-- ===== MODAL: INFO BESAR (Maks 5MB dll) ===== --}}
<div id="p3m-cropper-modal-besar" class="p3m-modal-overlay" role="dialog" aria-modal="true"
    aria-labelledby="modal-besar-title" hidden>
    <div class="p3m-modal-box p3m-modal-danger">
        <div class="p3m-modal-danger-header">
            <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
            <h4 id="modal-besar-title">Ukuran Foto Terlalu Besar</h4>
        </div>
        <div class="p3m-modal-body" id="p3m-cropper-modal-besar-body">
            <!-- Pesan error di-inject via JS -->
        </div>
        <div class="p3m-modal-actions">
            <button type="button" class="p3m-modal-btn p3m-modal-btn-ghost" id="p3m-cropper-btn-besar-ok">Pilih Foto
                Lain</button>
        </div>
    </div>
</div>

{{-- ===== MODAL: FORMAT TIDAK VALID ===== --}}
<div id="p3m-cropper-modal-format" class="p3m-modal-overlay" role="dialog" aria-modal="true"
    aria-labelledby="modal-format-title" hidden>
    <div class="p3m-modal-box p3m-modal-danger">
        <div class="p3m-modal-danger-header">
            <i class="fas fa-file-excel" aria-hidden="true"></i>
            <h4 id="modal-format-title">Format Foto Tidak Valid</h4>
        </div>
        <div class="p3m-modal-body" id="p3m-cropper-modal-format-body">
            <!-- Pesan error di-inject via JS -->
        </div>
        <div class="p3m-modal-actions">
            <button type="button" class="p3m-modal-btn p3m-modal-btn-ghost" id="p3m-cropper-btn-format-ok">Pilih Foto Lain</button>
        </div>
    </div>
</div>

{{-- ===== MODAL: CROP & PRATINJAU FOTO ===== --}}
<div id="p3m-cropper-modal-preview" class="p3m-modal-overlay" role="dialog" aria-modal="true"
    aria-labelledby="modal-preview-title" hidden>
    <div class="p3m-modal-box p3m-modal-preview">

        {{-- Header --}}
        <div class="p3m-modal-preview-header">
            <div class="p3m-modal-icon-wrap p3m-modal-icon-success">
                <i class="fas fa-crop-alt" aria-hidden="true"></i>
            </div>
            <div>
                <h4 id="modal-preview-title">Atur Posisi Foto</h4>
                <p>Geser dan sesuaikan foto agar pas di dalam lingkaran.</p>
            </div>
        </div>

        {{-- Custom Canvas Cropper area --}}
        <div class="p3m-cropper-container">
            <div class="p3m-custom-cropper" id="p3m-custom-crop-container">
                <img id="p3m-cropper-modal-preview-img" src="" alt="Pratinjau foto profil" draggable="false">
                <div class="p3m-crop-overlay"></div>
            </div>

            {{-- Sidebar info + kontrol --}}
            <div class="p3m-cropper-sidebar">

                <div class="p3m-preview-meta">
                    <div class="p3m-preview-meta-item">
                        <i class="fas fa-file-image" aria-hidden="true"></i>
                        <div>
                            <span class="p3m-preview-meta-label">Nama File</span>
                            <span id="p3m-cropper-preview-filename" class="p3m-preview-meta-value">-</span>
                        </div>
                    </div>
                    <div class="p3m-preview-meta-item">
                        <i class="fas fa-weight-hanging" aria-hidden="true"></i>
                        <div>
                            <span class="p3m-preview-meta-label">Ukuran Asli</span>
                            <span id="p3m-cropper-preview-filesize" class="p3m-preview-meta-value">-</span>
                        </div>
                    </div>
                </div>

                <div class="p3m-zoom-control-wrap">
                    <label class="p3m-zoom-label">Perbesar/Perkecil</label>
                    <div class="p3m-zoom-row">
                        <button type="button" class="p3m-zoom-side-btn" id="p3m-cropper-btn-zoom-out"
                            aria-label="Perkecil">
                            <i class="fas fa-minus" aria-hidden="true"></i>
                        </button>
                        <input type="range" class="p3m-zoom-slider" id="p3m-cropper-zoom-slider" min="0"
                            max="100" value="0" aria-label="Slider zoom foto">
                        <button type="button" class="p3m-zoom-side-btn" id="p3m-cropper-btn-zoom-in"
                            aria-label="Perbesar">
                            <i class="fas fa-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="p3m-zoom-reset-row">
                        <button type="button" class="p3m-zoom-reset-btn" id="p3m-cropper-btn-reset"
                            aria-label="Reset zoom">
                            <i class="fas fa-undo-alt" aria-hidden="true"></i> Reset
                        </button>
                    </div>
                </div>

            </div>
        </div>

        {{-- Footer --}}
        <div class="p3m-modal-actions">
            <button type="button" class="p3m-modal-btn p3m-modal-btn-ghost" id="p3m-cropper-btn-preview-ganti">
                <i class="fas fa-folder-open" aria-hidden="true"></i> Pilih File Lain
            </button>
            <button type="button" class="p3m-modal-btn p3m-modal-btn-primary" id="p3m-cropper-btn-preview-pakai">
                <i class="fas fa-check" aria-hidden="true"></i> Gunakan Foto Ini
            </button>
        </div>

    </div>
</div>
</div>

<style>
    /* ================================================================
   P3M Global Image Cropper Component CSS
   ================================================================ */
    .p3m-modal-overlay {
        position: fixed !important;
        inset: 0 !important;
        z-index: 99999 !important;
        background: rgba(0, 18, 11, 0.45) !important;
        backdrop-filter: blur(4px) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 20px !important;
        opacity: 1 !important;
        transition: opacity 0.2s ease !important;
    }

    .p3m-modal-overlay[hidden] {
        display: none !important;
        opacity: 0 !important;
    }

    .p3m-modal-box {
        background: #fff;
        border-radius: 24px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 24px 60px rgba(0, 30, 20, 0.15);
        transform: translateY(0) scale(1);
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        flex-direction: column;
    }

    .p3m-modal-overlay[hidden] .p3m-modal-box {
        transform: translateY(15px) scale(0.97);
    }

    .p3m-modal-danger-header {
        background: #fef2f2;
        color: #d94b4b;
        padding: 24px 24px 20px;
        border-radius: 24px 24px 0 0;
        text-align: center;
    }

    .p3m-modal-danger-header i {
        font-size: 36px;
        margin-bottom: 12px;
    }

    .p3m-modal-danger-header h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 800;
    }

    .p3m-modal-body {
        padding: 24px;
        color: #52675e;
        font-size: 13.5px;
        line-height: 1.6;
        text-align: center;
    }

    .p3m-modal-preview {
        max-width: 680px;
        overflow: hidden;
    }

    .p3m-modal-preview-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 22px 16px;
        border-bottom: 1px solid #e4ede8;
    }

    .p3m-modal-icon-wrap {
        margin: 0;
        flex: 0 0 44px;
        width: 44px;
        height: 44px;
        font-size: 17px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .p3m-modal-icon-success {
        background: #eaf6ef;
        color: #00573b;
    }

    .p3m-modal-preview-header h4 {
        margin: 0;
        color: #0d1f1a;
        font-size: 14.5px;
        font-weight: 800;
    }

    .p3m-modal-preview-header p {
        margin: 2px 0 0;
        color: #6b7f78;
        font-size: 10.5px;
    }

    .p3m-cropper-container {
        display: grid;
        grid-template-columns: 400px 1fr;
        background: #fdfdfd;
    }

    .p3m-cropper-sidebar {
        padding: 20px;
        border-left: 1px solid #e4ede8;
        background: #fff;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .p3m-preview-meta {
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 14px;
        background: #f4f8f6;
        border-radius: 14px;
        border: 1px solid #eef3f0;
    }

    .p3m-preview-meta-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .p3m-preview-meta-item i {
        color: #00573b;
        font-size: 14px;
        margin-top: 3px;
    }

    .p3m-preview-meta-label {
        display: block;
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #6b7f78;
        margin-bottom: 2px;
    }

    .p3m-preview-meta-value {
        display: block;
        color: #0d1f1a;
        font-weight: 600;
        font-size: 12px;
        word-break: break-all;
    }

    .p3m-zoom-control-wrap {
        padding-top: 4px;
    }

    .p3m-zoom-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #3b4f47;
        margin-bottom: 10px;
        text-align: center;
    }

    .p3m-zoom-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .p3m-zoom-side-btn {
        width: 28px;
        height: 28px;
        flex: 0 0 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid #cdddd5;
        border-radius: 50%;
        background: #fff;
        color: #00573b;
        font-size: 10px;
        cursor: pointer;
        transition: background 0.15s, border-color 0.15s, box-shadow 0.15s;
    }

    .p3m-zoom-side-btn:hover {
        background: #eaf6ef;
        border-color: #00573b;
        box-shadow: 0 2px 6px rgba(7, 62, 45, 0.12);
    }

    .p3m-zoom-slider {
        flex: 1;
        -webkit-appearance: none;
        appearance: none;
        height: 4px;
        border-radius: 999px;
        background: linear-gradient(to right, #00573b 50%, #d7e2dc 50%);
        outline: none;
        cursor: pointer;
    }

    .p3m-zoom-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #fff;
        border: 2.5px solid #00573b;
        box-shadow: 0 2px 8px rgba(7, 62, 45, 0.22);
        cursor: grab;
    }

    .p3m-zoom-slider::-webkit-slider-thumb:hover {
        box-shadow: 0 3px 12px rgba(7, 62, 45, 0.3);
        transform: scale(1.1);
    }

    .p3m-zoom-reset-row {
        margin-top: 10px;
        display: flex;
        justify-content: center;
    }

    .p3m-zoom-reset-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 14px;
        border: 1.5px solid #d7e2dc;
        border-radius: 999px;
        background: #fff;
        color: #6b7f78;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    .p3m-zoom-reset-btn:hover {
        background: #fef9ef;
        color: #c07a1a;
        border-color: #e6c97a;
    }

    .p3m-modal-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        padding: 14px 20px 16px;
        border-top: 1px solid #e4ede8;
    }

    .p3m-modal-danger .p3m-modal-actions {
        justify-content: center;
        border-top: none;
        padding-top: 0;
    }

    .p3m-modal-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 18px;
        border-radius: 10px;
        border: 1px solid transparent;
        font-size: 11.5px;
        font-weight: 800;
        cursor: pointer;
    }

    .p3m-modal-btn-primary {
        background: #001e16;
        border-color: #001e16;
        color: #fff;
    }

    .p3m-modal-btn-primary:hover {
        background: #000;
        border-color: #000;
    }

    .p3m-modal-btn-ghost {
        background: #fff;
        border-color: #d7e2dc;
        color: #52675e;
    }

    .p3m-modal-btn-ghost:hover {
        background: #f4f8f6;
        border-color: #c6d6ce;
    }

    .p3m-custom-cropper {
        position: relative;
        width: 100%;
        height: 380px;
        background: #eaf6ef;
        overflow: hidden;
        cursor: grab;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .p3m-custom-cropper:active {
        cursor: grabbing;
    }

    #p3m-cropper-modal-preview-img {
        position: absolute;
        left: 0;
        top: 0;
        transform-origin: 0 0;
        will-change: transform;
        user-select: none;
        -webkit-user-drag: none;
    }

    .p3m-crop-overlay {
        position: absolute;
        left: 50%;
        top: 50%;
        width: 250px;
        height: 250px;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        box-shadow: 0 0 0 9999px rgba(0, 30, 20, 0.65);
        border: 2px dashed rgba(255, 255, 255, 0.85);
        pointer-events: none;
        z-index: 10;
    }

    @media (max-width: 640px) {
        .p3m-cropper-container {
            grid-template-columns: 1fr;
        }

        .p3m-cropper-sidebar {
            border-left: none;
            border-top: 1px solid #e4ede8;
        }
    }
</style>

<script data-turbo-eval="false">
    (function() {
        'use strict';

        if (window.__p3mCropperInitialized) return;
        window.__p3mCropperInitialized = true;

        const MAX_MB = 5;
        const MAX_BYTES = MAX_MB * 1024 * 1024;
        const WEBP_QUALITY = 0.85;
        const OUTPUT_SIZE = 480;
        const CROP_SIZE = 250;
        const ALLOWED_EXTS = ['jpg', 'jpeg', 'png', 'webp'];
        const ALLOWED_MIMES = ['image/jpeg', 'image/png', 'image/webp'];

        // Cropper State
        let imgBaseWidth = 0,
            imgBaseHeight = 0;
        let imgScale = 1;
        let imgX = 0,
            imgY = 0;
        let isDragging = false;
        let startX = 0,
            startY = 0;
        let initialX = 0,
            initialY = 0;
        let activeFileInput = null;

        function getEl(id) {
            return document.getElementById(id);
        }

        function openModal(el) {
            if (!el) return;
            el.removeAttribute('hidden');
            el.hidden = false;
            document.body.style.overflow = 'hidden';
        }

        function closeModal(el) {
            if (!el) return;
            el.hidden = true;
            el.setAttribute('hidden', '');
            document.body.style.overflow = '';
        }

        function destroyCropper() {
            imgScale = 1;
            imgX = 0;
            imgY = 0;
            const img = getEl('p3m-cropper-modal-preview-img');
            if (img) {
                img.style.transform = 'none';
                img.src = '';
            }
            const slider = getEl('p3m-cropper-zoom-slider');
            if (slider) {
                slider.value = 0;
                updateSliderGradient(0);
            }
        }

        function formatBytes(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(0) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
        }

        function getExtension(filename) {
            const parts = (filename || '').toLowerCase().split('.');
            return parts.length > 1 ? parts.pop() : '';
        }

        function updateSliderGradient(val) {
            const slider = getEl('p3m-cropper-zoom-slider');
            if (slider) {
                slider.style.background =
                    `linear-gradient(to right, #00573b ${val}%, #d7e2dc ${val}%)`;
            }
        }

        function updateImgTransform() {
            const img = getEl('p3m-cropper-modal-preview-img');
            if (!img) return;
            img.style.width = `${imgBaseWidth * imgScale}px`;
            img.style.height = `${imgBaseHeight * imgScale}px`;
            img.style.transform = `translate(${imgX}px, ${imgY}px)`;
        }

        function constrainPosition() {
            const container = getEl('p3m-custom-crop-container');
            if (!container) return;
            const currentW = imgBaseWidth * imgScale;
            const currentH = imgBaseHeight * imgScale;
            const containerW = container.clientWidth || 400;
            const containerH = container.clientHeight || 380;

            const minX = (containerW / 2) + (CROP_SIZE / 2) - currentW;
            const maxX = (containerW / 2) - (CROP_SIZE / 2);
            const minY = (containerH / 2) + (CROP_SIZE / 2) - currentH;
            const maxY = (containerH / 2) - (CROP_SIZE / 2);

            imgX = Math.min(Math.max(imgX, minX), maxX);
            imgY = Math.min(Math.max(imgY, minY), maxY);
        }

        function setZoom(newScale) {
            const container = getEl('p3m-custom-crop-container');
            if (!container) return;
            const containerW = container.clientWidth || 400;
            const containerH = container.clientHeight || 380;
            const cx = containerW / 2;
            const cy = containerH / 2;

            const localX = (cx - imgX) / imgScale;
            const localY = (cy - imgY) / imgScale;

            imgScale = newScale;
            imgX = cx - (localX * imgScale);
            imgY = cy - (localY * imgScale);

            constrainPosition();
            updateImgTransform();
        }

        function sliderToScale(val) {
            return 1.0 + (val / 100) * 3.0;
        }

        // Global file change listener on document
        document.addEventListener('change', function(e) {
            const fileInput = e.target.closest ? e.target.closest('.p3m-cropper-input') : null;
            if (!fileInput) return;

            const file = fileInput.files && fileInput.files[0];
            if (!file) return;

            // Format validation
            const ext = getExtension(file.name);
            const mime = (file.type || '').toLowerCase();
            const extOk = ALLOWED_EXTS.includes(ext);
            const mimeOk = ALLOWED_MIMES.includes(mime) || mime.startsWith('image/');

            if (!extOk || !mimeOk) {
                const modalFormat = getEl('p3m-cropper-modal-format');
                const modalFormatBody = getEl('p3m-cropper-modal-format-body');
                if (modalFormatBody) {
                    modalFormatBody.innerHTML =
                        'File <strong>' + file.name.replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</strong>' +
                        ' bukan format foto yang didukung. Gunakan <strong>PNG, JPG, JPEG,</strong> atau <strong>WebP</strong>.';
                }
                fileInput.value = '';
                openModal(modalFormat);
                return;
            }

            // Size validation
            if (file.size > MAX_BYTES) {
                const modalBesar = getEl('p3m-cropper-modal-besar');
                const modalBesarBody = getEl('p3m-cropper-modal-besar-body');
                if (modalBesarBody) {
                    modalBesarBody.innerHTML = 'Foto yang Anda pilih berukuran <strong>' +
                        formatBytes(file.size) +
                        '</strong>. Batas maksimal ukuran foto adalah <strong>' + MAX_MB +
                        ' MB</strong>.';
                }
                fileInput.value = '';
                openModal(modalBesar);
                return;
            }

            activeFileInput = fileInput;

            const modalPreview = getEl('p3m-cropper-modal-preview');
            const modalPreviewImg = getEl('p3m-cropper-modal-preview-img');
            const previewFilename = getEl('p3m-cropper-preview-filename');
            const previewFilesize = getEl('p3m-cropper-preview-filesize');
            const customCropContainer = getEl('p3m-custom-crop-container');
            const zoomSlider = getEl('p3m-cropper-zoom-slider');

            const reader = new FileReader();
            reader.onload = function(evt) {
                destroyCropper();

                if (previewFilename) previewFilename.textContent = file.name;
                if (previewFilesize) previewFilesize.textContent = formatBytes(file.size);

                openModal(modalPreview);

                if (modalPreviewImg) {
                    modalPreviewImg.onload = function() {
                        const nw = this.naturalWidth;
                        const nh = this.naturalHeight;

                        const scaleFit = Math.max(CROP_SIZE / nw, CROP_SIZE / nh);
                        imgBaseWidth = nw * scaleFit;
                        imgBaseHeight = nh * scaleFit;

                        requestAnimationFrame(() => {
                            const containerW = customCropContainer ? (customCropContainer.clientWidth || 400) : 400;
                            const containerH = customCropContainer ? (customCropContainer.clientHeight || 380) : 380;

                            imgScale = 1;
                            imgX = (containerW - imgBaseWidth) / 2;
                            imgY = (containerH - imgBaseHeight) / 2;

                            constrainPosition();
                            updateImgTransform();

                            if (zoomSlider) {
                                zoomSlider.value = 0;
                                updateSliderGradient(0);
                            }
                        });
                    };
                    modalPreviewImg.src = evt.target.result;
                }
            };
            reader.readAsDataURL(file);
        });

        // Global input handler for zoom slider
        document.addEventListener('input', function(e) {
            if (e.target && e.target.id === 'p3m-cropper-zoom-slider') {
                const val = parseInt(e.target.value, 10) || 0;
                setZoom(sliderToScale(val));
                updateSliderGradient(val);
            }
        });

        // Global click handler for modal buttons
        document.addEventListener('click', function(e) {
            // Modal Format OK
            if (e.target.closest('#p3m-cropper-btn-format-ok')) {
                closeModal(getEl('p3m-cropper-modal-format'));
                return;
            }

            // Modal Besar OK
            if (e.target.closest('#p3m-cropper-btn-besar-ok')) {
                closeModal(getEl('p3m-cropper-modal-besar'));
                if (activeFileInput) activeFileInput.click();
                return;
            }

            // Ganti foto
            if (e.target.closest('#p3m-cropper-btn-preview-ganti')) {
                closeModal(getEl('p3m-cropper-modal-preview'));
                destroyCropper();
                if (activeFileInput) {
                    activeFileInput.value = '';
                    activeFileInput.click();
                }
                return;
            }

            // Zoom In
            if (e.target.closest('#p3m-cropper-btn-zoom-in')) {
                const zoomSlider = getEl('p3m-cropper-zoom-slider');
                if (!zoomSlider) return;
                const newVal = Math.min(100, (parseInt(zoomSlider.value, 10) || 0) + 10);
                zoomSlider.value = newVal;
                setZoom(sliderToScale(newVal));
                updateSliderGradient(newVal);
                return;
            }

            // Zoom Out
            if (e.target.closest('#p3m-cropper-btn-zoom-out')) {
                const zoomSlider = getEl('p3m-cropper-zoom-slider');
                if (!zoomSlider) return;
                const newVal = Math.max(0, (parseInt(zoomSlider.value, 10) || 0) - 10);
                zoomSlider.value = newVal;
                setZoom(sliderToScale(newVal));
                updateSliderGradient(newVal);
                return;
            }

            // Reset Zoom
            if (e.target.closest('#p3m-cropper-btn-reset')) {
                const customCropContainer = getEl('p3m-custom-crop-container');
                const zoomSlider = getEl('p3m-cropper-zoom-slider');
                const containerW = customCropContainer ? (customCropContainer.clientWidth || 400) : 400;
                const containerH = customCropContainer ? (customCropContainer.clientHeight || 380) : 380;

                imgScale = 1;
                imgX = (containerW - imgBaseWidth) / 2;
                imgY = (containerH - imgBaseHeight) / 2;
                constrainPosition();
                updateImgTransform();
                if (zoomSlider) {
                    zoomSlider.value = 0;
                    updateSliderGradient(0);
                }
                return;
            }

            // Gunakan Foto Ini (Crop & Save)
            const btnPakai = e.target.closest('#p3m-cropper-btn-preview-pakai');
            if (btnPakai) {
                const modalPreviewImg = getEl('p3m-cropper-modal-preview-img');
                const customCropContainer = getEl('p3m-custom-crop-container');
                const modalPreview = getEl('p3m-cropper-modal-preview');

                if (!modalPreviewImg || !modalPreviewImg.src || !activeFileInput || !customCropContainer) return;

                btnPakai.disabled = true;
                const originalBtnHtml = btnPakai.innerHTML;
                btnPakai.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses…';

                try {
                    const canvas = document.createElement('canvas');
                    canvas.width = OUTPUT_SIZE;
                    canvas.height = OUTPUT_SIZE;
                    const ctx = canvas.getContext('2d');

                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, OUTPUT_SIZE, OUTPUT_SIZE);

                    const containerW = customCropContainer.clientWidth || 400;
                    const containerH = customCropContainer.clientHeight || 380;

                    const cropBoxLeft = (containerW / 2) - (CROP_SIZE / 2);
                    const cropBoxTop = (containerH / 2) - (CROP_SIZE / 2);

                    const drawX = imgX - cropBoxLeft;
                    const drawY = imgY - cropBoxTop;
                    const outRatio = OUTPUT_SIZE / CROP_SIZE;

                    ctx.imageSmoothingEnabled = true;
                    ctx.imageSmoothingQuality = 'high';
                    ctx.drawImage(
                        modalPreviewImg,
                        drawX * outRatio,
                        drawY * outRatio,
                        imgBaseWidth * imgScale * outRatio,
                        imgBaseHeight * imgScale * outRatio
                    );

                    let base64Data = '';
                    try {
                        base64Data = canvas.toDataURL('image/webp', WEBP_QUALITY);
                        if (!base64Data.startsWith('data:image/webp')) {
                            base64Data = canvas.toDataURL('image/jpeg', 0.88);
                        }
                    } catch (e) {
                        base64Data = canvas.toDataURL('image/jpeg', 0.88);
                    }

                    // 1. Inject to target hidden input
                    const targetSelector = activeFileInput.getAttribute('data-base64-target');
                    if (targetSelector) {
                        const hiddenInput = document.querySelector(targetSelector);
                        if (hiddenInput) {
                            hiddenInput.value = base64Data;
                            hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
                            hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    }

                    // 2. Update thumbnail preview image
                    const previewSelector = activeFileInput.getAttribute('data-preview-target');
                    if (previewSelector) {
                        const previewImg = document.querySelector(previewSelector);
                        if (previewImg) {
                            previewImg.src = base64Data;
                            previewImg.style.display = 'block';

                            // Hide placeholder initials/icon if present
                            const placeholder = document.getElementById('photo-placeholder') ||
                                (previewImg.parentElement ? previewImg.parentElement.querySelector('span') : null);
                            if (placeholder) {
                                placeholder.style.display = 'none';
                            }
                        }
                    }

                    // 3. Update status badge if present
                    const statusBadge = document.querySelector('.dosen-profile-photo-status');
                    if (statusBadge) {
                        statusBadge.innerHTML = '<i class="fas fa-check" aria-hidden="true"></i> Foto siap disimpan';
                        statusBadge.style.display = 'inline-flex';
                    }

                    // 4. Update file label info if present
                    const helpText = document.getElementById('photo-help');
                    if (helpText) {
                        helpText.textContent = 'Foto berhasil disesuaikan · Klik Simpan Perubahan';
                        helpText.style.color = '#00573b';
                    }

                    // Clear original file input so clean base64 is submitted
                    activeFileInput.value = '';
                    closeModal(modalPreview);
                    destroyCropper();
                    activeFileInput = null;
                } catch (err) {
                    console.error('Error cropping image:', err);
                } finally {
                    btnPakai.disabled = false;
                    btnPakai.innerHTML = originalBtnHtml;
                }
                return;
            }

            // Backdrop click on overlays
            const overlay = e.target.closest('.p3m-modal-overlay');
            if (overlay && e.target === overlay) {
                closeModal(overlay);
                destroyCropper();
                if (activeFileInput) {
                    activeFileInput.value = '';
                    activeFileInput = null;
                }
            }
        });

        // Dragging & Panning
        document.addEventListener('mousedown', function(e) {
            const cropContainer = e.target.closest('#p3m-custom-crop-container');
            if (!cropContainer) return;
            e.preventDefault();
            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;
            initialX = imgX;
            initialY = imgY;
        });

        window.addEventListener('mousemove', function(e) {
            if (!isDragging) return;
            imgX = initialX + (e.clientX - startX);
            imgY = initialY + (e.clientY - startY);
            constrainPosition();
            updateImgTransform();
        });

        window.addEventListener('mouseup', function() {
            isDragging = false;
        });

        // Touch Dragging
        document.addEventListener('touchstart', function(e) {
            const cropContainer = e.target.closest('#p3m-custom-crop-container');
            if (!cropContainer || e.touches.length !== 1) return;
            isDragging = true;
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            initialX = imgX;
            initialY = imgY;
        }, { passive: true });

        window.addEventListener('touchmove', function(e) {
            if (!isDragging || e.touches.length !== 1) return;
            imgX = initialX + (e.touches[0].clientX - startX);
            imgY = initialY + (e.touches[0].clientY - startY);
            constrainPosition();
            updateImgTransform();
        }, { passive: true });

        window.addEventListener('touchend', function() {
            isDragging = false;
        });

        // Escape Key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModals = document.querySelectorAll('.p3m-modal-overlay:not([hidden])');
                openModals.forEach(m => {
                    closeModal(m);
                });
                destroyCropper();
                if (activeFileInput) {
                    activeFileInput.value = '';
                    activeFileInput = null;
                }
            }
        });

    })();
</script>
