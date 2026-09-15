{{--
    Client-side upload guard. Server-side validation remains authoritative; this
    component only gives the user an immediate, accessible explanation before a
    form is submitted. It manages P3M inputs named `uppdf` and `foto`; explicit
    data attributes may override the standard labels or size limits.
--}}
<style>
    .p3m-upload-invalid {
        border-color: #d94b4b !important;
        background: #fef2f2 !important;
    }
</style>
<script>
    (function() {
        'use strict';

        const genericMimeTypes = ['', 'application/octet-stream'];
        let alertQueue = Promise.resolve();
@php
    $serverUploadErrors = [
        'uppdf' => $errors->first('uppdf'),
        'foto' => $errors->first('foto'),
        'image' => $errors->first('image'),
        'original_name' => $errors->first('original_name'),
        'originalname' => $errors->first('originalname'),
        'file' => $errors->first('file'),
    ];
@endphp

        const serverUploadErrors = {!! json_encode($serverUploadErrors) !!};

        function isManagedUpload(input) {
            return input instanceof HTMLInputElement &&
                input.type === 'file' &&
                !input.classList.contains('p3m-cropper-input') &&
                !input.closest('[data-p3m-upload-exclude]') &&
                (input.hasAttribute('data-p3m-upload') || ['uppdf', 'foto', 'image', 'original_name', 'originalname', 'file'].includes(input.name));
        }

        function escapeHtml(value) {
            const element = document.createElement('div');
            element.textContent = String(value || '');
            return element.innerHTML;
        }

        function formatBytes(bytes) {
            if (!bytes) {
                return '0 B';
            }

            const units = ['B', 'KB', 'MB', 'GB'];
            const index = Math.min(Math.floor(Math.log(bytes) / Math.log(1024)), units.length - 1);
            const value = bytes / Math.pow(1024, index);

            return value.toFixed(index === 0 ? 0 : 1).replace(/\.0$/, '') + ' ' + units[index];
        }

        function getOptions(input) {
            let defaults;
            if (input.name === 'foto') {
                defaults = {
                    label: 'Foto kegiatan',
                    emptyLabel: 'Pilih gambar / foto',
                    formats: 'JPG atau PNG',
                    maxBytes: 2 * 1024 * 1024,
                    extensions: ['jpg', 'jpeg', 'png'],
                    mimeTypes: ['image/jpeg', 'image/png'],
                };
            } else if (input.name === 'image') {
                defaults = {
                    label: 'Gambar kegiatan',
                    emptyLabel: 'Pilih gambar / foto',
                    formats: 'PNG, JPG, JPEG, WEBP, atau GIF',
                    maxBytes: 5 * 1024 * 1024,
                    extensions: ['jpg', 'jpeg', 'png', 'webp', 'gif'],
                    mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/gif'],
                };
            } else if (input.name === 'uppdf') {
                defaults = {
                    label: 'Dokumen laporan',
                    emptyLabel: 'Pilih file laporan',
                    formats: 'PDF',
                    maxBytes: 5 * 1024 * 1024,
                    extensions: ['pdf'],
                    mimeTypes: ['application/pdf'],
                };
            } else {
                defaults = {
                    label: 'Dokumen',
                    emptyLabel: 'Pilih file dokumen',
                    formats: 'PDF atau DOCX',
                    maxBytes: 5 * 1024 * 1024,
                    extensions: ['pdf', 'docx', 'doc'],
                    mimeTypes: ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
                };
            }

            return {
                label: input.dataset.p3mUploadLabel || defaults.label,
                emptyLabel: input.dataset.p3mUploadEmptyLabel || defaults.emptyLabel,
                formats: input.dataset.p3mUploadFormats || defaults.formats,
                maxBytes: Number(input.dataset.p3mUploadMaxBytes || defaults.maxBytes),
                extensions: (input.dataset.p3mUploadExtensions || '')
                    .split(',')
                    .map(function(extension) {
                        return extension.trim().toLowerCase();
                    })
                    .filter(Boolean).concat(input.dataset.p3mUploadExtensions ? [] : defaults.extensions),
                mimeTypes: (input.dataset.p3mUploadMimeTypes || '')
                    .split(',')
                    .map(function(mimeType) {
                        return mimeType.trim().toLowerCase();
                    })
                    .filter(Boolean).concat(input.dataset.p3mUploadMimeTypes ? [] : defaults.mimeTypes),
            };
        }

        function getFileNameElement(input) {
            const labelId = input.dataset.p3mUploadNameId;

            return labelId ? document.getElementById(labelId) : null;
        }

        function setUploadState(input, isInvalid, message) {
            const wrapper = input.closest('.report-add-upload, .peng-edit-file-wrap, .news-upload-box');
            const labels = Array.from(document.querySelectorAll('label')).filter(function(label) {
                return label.htmlFor === input.id;
            });

            input.setAttribute('aria-invalid', isInvalid ? 'true' : 'false');
            input.setCustomValidity(isInvalid ? message : '');

            if (wrapper) {
                wrapper.classList.toggle('is-invalid', isInvalid);
            }

            labels.forEach(function(label) {
                label.classList.toggle('p3m-upload-invalid', isInvalid);
            });
        }

        function resetInput(input) {
            const options = getOptions(input);
            const nameElement = getFileNameElement(input);
            const cachedName = input.dataset.p3mCachedName;

            input.value = '';

            if (nameElement) {
                nameElement.textContent = cachedName || options.emptyLabel;
            }
        }

        function showAlert(title, message, buttonText) {
            alertQueue = alertQueue.then(function() {
                return new Promise(function(resolve) {
                    if (typeof window.p3mError === 'function') {
                        window.p3mError(message, title, buttonText);
                        setTimeout(resolve, 300);
                    } else if (typeof window.Swal === 'function') {
                        window.Swal.fire({
                            icon: 'error',
                            title: title,
                            html: message,
                            showConfirmButton: true,
                            confirmButtonText: buttonText || 'Tutup',
                            customClass: {
                                popup: 'p3m-swal-popup',
                                confirmButton: 'p3m-swal-btn-danger'
                            },
                            buttonsStyling: false
                        }).then(resolve);
                    } else {
                        window.alert(title + '\n\n' + message.replace(/<[^>]*>/g, ''));
                        resolve();
                    }
                });
            });

        }

        function showValidationError(input, title, message, buttonText) {
            setUploadState(input, true, message.replace(/<[^>]*>/g, ''));
            resetInput(input);

            return Promise.resolve(showAlert(title, message, buttonText)).then(function() {
                input.focus({
                    preventScroll: true
                });
            });
        }

        function hasAllowedFormat(file, options) {
            const fileName = (file.name || '').toLowerCase();
            const extension = fileName.includes('.') ? fileName.split('.').pop() : '';
            const mimeType = (file.type || '').toLowerCase();

            const extensionIsAllowed = !options.extensions.length || options.extensions.includes(extension);
            const mimeIsAllowed = !options.mimeTypes.length ||
                genericMimeTypes.includes(mimeType) ||
                options.mimeTypes.includes(mimeType);

            return extensionIsAllowed && mimeIsAllowed;
        }

        function validateInput(input, shouldNotify) {
            const file = input.files && input.files[0];
            const options = getOptions(input);
            const nameElement = getFileNameElement(input);
            const cachedName = input.dataset.p3mCachedName;

            if (!file) {
                if (nameElement) {
                    nameElement.textContent = cachedName || options.emptyLabel;
                }

                setUploadState(input, false, '');

                return true;
            }

            if (!hasAllowedFormat(file, options)) {
                const message = escapeHtml(options.label) + ' hanya dapat menggunakan format <strong>' +
                    escapeHtml(options.formats) + '</strong>.';

                if (shouldNotify) {
                    showValidationError(input, 'Format File Tidak Valid', message, 'Pilih File Lain');
                } else {
                    setUploadState(input, true, message.replace(/<[^>]*>/g, ''));
                }

                return false;
            }

            if (options.maxBytes > 0 && file.size > options.maxBytes) {
                const message = escapeHtml(options.label) + ' yang dipilih berukuran <strong>' +
                    formatBytes(file.size) + '</strong>. Batas maksimalnya adalah <strong>' +
                    formatBytes(options.maxBytes) + '</strong>.';

                if (shouldNotify) {
                    showValidationError(input, 'Ukuran File Terlalu Besar', message, 'Pilih File Lain');
                } else {
                    setUploadState(input, true, message.replace(/<[^>]*>/g, ''));
                }

                return false;
            }

            setUploadState(input, false, '');

            if (nameElement) {
                nameElement.textContent = file.name;
            }

            return true;
        }

        function showServerValidationErrors() {
            document.querySelectorAll('input[type="file"]').forEach(function(input) {
                if (!isManagedUpload(input)) {
                    return;
                }

                if (input.dataset.p3mUploadErrorShown === 'true') {
                    return;
                }

                const error = input.dataset.p3mUploadError || serverUploadErrors[input.name];

                if (!error) {
                    return;
                }

                input.dataset.p3mUploadErrorShown = 'true';
                setUploadState(input, true, error);

                showAlert(
                    'Unggahan Tidak Dapat Diproses',
                    '<strong>' + escapeHtml(getOptions(input).label) + ':</strong> ' + escapeHtml(
                        error),
                    'Periksa Kembali'
                ).then(function() {
                    input.closest('.report-add-field, .peng-edit-field')?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                });
            });
        }

        function prepareManagedUploads() {
            document.querySelectorAll('input[type="file"]').forEach(function(input) {
                if (!isManagedUpload(input) || input.hasAttribute('data-p3m-upload-preserve-accept')) {
                    return;
                }

                if (input.name === 'foto') {
                    input.accept = input.getAttribute('accept') || '.jpg,.jpeg,.png,image/jpeg,image/png';
                } else if (input.name === 'image') {
                    input.accept = input.getAttribute('accept') || '.png,.jpg,.jpeg,.webp,.gif,image/png,image/jpeg,image/webp,image/gif';
                } else if (input.name === 'uppdf') {
                    input.accept = input.getAttribute('accept') || '.pdf,application/pdf';
                } else {
                    input.accept = input.getAttribute('accept') || '.pdf,.docx,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                }
            });
        }

        function initializeManagedUploads() {
            prepareManagedUploads();
            showServerValidationErrors();
        }

        document.addEventListener('change', function(event) {
            const input = event.target instanceof Element ? event.target.closest('input[type="file"]') :
                null;

            if (isManagedUpload(input)) {
                validateInput(input, true);
            }
        }, true);

        document.addEventListener('submit', function(event) {
            const inputs = Array.from(event.target.querySelectorAll('input[type="file"]')).filter(
                isManagedUpload);

            for (const input of inputs) {
                if (!validateInput(input, false)) {
                    event.preventDefault();
                    showValidationError(input, 'Unggahan Belum Valid', input.validationMessage,
                        'Pilih File Lain');
                    break;
                }
            }
        }, true);

        document.addEventListener('DOMContentLoaded', initializeManagedUploads);
        document.addEventListener('turbo:load', initializeManagedUploads);
    })();
</script>
