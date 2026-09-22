/**
 * ============================================================================
 * P3M POLIBANG — GLOBAL CUSTOM DROPDOWN COMPONENT
 * Lightweight, accessible, and beautifully styled dropdown for P3M Workspace.
 * ============================================================================
 */

(function () {
    'use strict';

    // Singleton guard to prevent duplicate listener registration across Turbo visits
    if (window.__p3mDropdownScriptLoaded) {
        return;
    }
    window.__p3mDropdownScriptLoaded = true;

    // Close all open dropdowns
    function closeAllDropdowns(exceptDropdown) {
        document.querySelectorAll('.p3m-custom-dropdown.is-open').forEach(function (dd) {
            if (dd !== exceptDropdown) {
                dd.classList.remove('is-open');
                const trigger = dd.querySelector('.p3m-dropdown-trigger');
                if (trigger) {
                    trigger.setAttribute('aria-expanded', 'false');
                }
            }
        });
    }

    // Toggle a dropdown with debounce protection
    function toggleDropdown(dropdown) {
        if (!dropdown) return;
        const now = Date.now();
        if (dropdown._lastToggle && (now - dropdown._lastToggle < 120)) {
            return;
        }
        dropdown._lastToggle = now;

        const isOpen = dropdown.classList.contains('is-open');
        closeAllDropdowns(isOpen ? null : dropdown);

        if (!isOpen) {
            dropdown.classList.add('is-open');
            const trigger = dropdown.querySelector('.p3m-dropdown-trigger');
            if (trigger) {
                trigger.setAttribute('aria-expanded', 'true');
            }

            // Adjust alignment if overflowing right viewport
            const menu = dropdown.querySelector('.p3m-dropdown-menu');
            if (menu) {
                menu.classList.remove('dropdown-menu-right');
                const rect = menu.getBoundingClientRect();
                if (rect.right > (window.innerWidth || document.documentElement.clientWidth) - 16) {
                    menu.classList.add('dropdown-menu-right');
                }
            }
        } else {
            dropdown.classList.remove('is-open');
            const trigger = dropdown.querySelector('.p3m-dropdown-trigger');
            if (trigger) {
                trigger.setAttribute('aria-expanded', 'false');
            }
        }
    }

    // Select an option item with debounce protection
    function selectOption(item) {
        if (!item) return;
        const now = Date.now();
        if (item._lastSelect && (now - item._lastSelect < 200)) {
            return;
        }
        item._lastSelect = now;

        const dropdown = item.closest('.p3m-custom-dropdown');
        if (!dropdown) return;

        const val = item.getAttribute('data-value') !== null ? item.getAttribute('data-value') : item.textContent.trim();
        const displayLabel = item.getAttribute('data-label') || item.querySelector('.p3m-dropdown-item-text')?.textContent.trim() || item.textContent.trim();

        // Update active class
        dropdown.querySelectorAll('.p3m-dropdown-item').forEach(function (opt) {
            opt.classList.remove('active');
        });
        item.classList.add('active');

        // Update trigger text
        const labelEl = dropdown.querySelector('.p3m-dropdown-label');
        if (labelEl) {
            labelEl.textContent = displayLabel;
        }

        const trigger = dropdown.querySelector('.p3m-dropdown-trigger');
        if (trigger) {
            trigger.setAttribute('aria-expanded', 'false');
            trigger.focus();
        }

        // Update hidden input or native select
        let input = dropdown.querySelector('input[type="hidden"], select');
        if (!input && dropdown.hasAttribute('data-target')) {
            input = document.querySelector(dropdown.getAttribute('data-target'));
        }

        if (input) {
            input.value = val;
            // Native dispatch
            input.dispatchEvent(new Event('change', { bubbles: true }));
            input.dispatchEvent(new Event('input', { bubbles: true }));

            // jQuery dispatch if available
            if (typeof window.jQuery !== 'undefined') {
                window.jQuery(input).trigger('change');
            }
        }

        // Close dropdown
        dropdown.classList.remove('is-open');

        // Custom event for listeners
        dropdown.dispatchEvent(new CustomEvent('p3m:dropdown:change', {
            bubbles: true,
            detail: { value: val, label: displayLabel, item: item }
        }));
    }

    // Programmatic set value
    window.setP3mDropdownValue = function (dropdownOrId, value) {
        const dropdown = typeof dropdownOrId === 'string' ? document.getElementById(dropdownOrId) : dropdownOrId;
        if (!dropdown) return;

        const items = dropdown.querySelectorAll('.p3m-dropdown-item');
        let matchedItem = null;

        items.forEach(function (item) {
            const itemVal = item.getAttribute('data-value') !== null ? item.getAttribute('data-value') : item.textContent.trim();
            if (String(itemVal) === String(value)) {
                matchedItem = item;
            }
        });

        if (matchedItem) {
            selectOption(matchedItem);
        }
    };

    // Event delegation on document
    document.addEventListener('click', function (e) {
        // Trigger click
        const trigger = e.target.closest('.p3m-dropdown-trigger') || (e.target.classList.contains('p3m-custom-dropdown') ? e.target.querySelector('.p3m-dropdown-trigger') : null);
        if (trigger) {
            const dropdown = trigger.closest('.p3m-custom-dropdown');
            if (dropdown && !dropdown.classList.contains('disabled')) {
                e.preventDefault();
                e.stopPropagation();
                toggleDropdown(dropdown);
                return;
            }
        }

        // Option click
        const item = e.target.closest('.p3m-dropdown-item');
        if (item && !item.classList.contains('disabled')) {
            e.preventDefault();
            e.stopPropagation();
            selectOption(item);
            return;
        }

        // Click outside closes all open dropdowns
        if (!e.target.closest('.p3m-custom-dropdown')) {
            closeAllDropdowns();
        }
    }, false);

    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAllDropdowns();
            return;
        }

        const openDropdown = document.querySelector('.p3m-custom-dropdown.is-open');
        if (!openDropdown) return;

        const items = Array.from(openDropdown.querySelectorAll('.p3m-dropdown-item:not(.disabled)'));
        if (!items.length) return;

        const activeIndex = items.findIndex(function (it) {
            return it === document.activeElement || it.classList.contains('active');
        });

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            const nextIndex = activeIndex < items.length - 1 ? activeIndex + 1 : 0;
            items[nextIndex].focus();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            const prevIndex = activeIndex > 0 ? activeIndex - 1 : items.length - 1;
            items[prevIndex].focus();
        } else if (e.key === 'Enter' || e.key === ' ') {
            if (document.activeElement && document.activeElement.classList.contains('p3m-dropdown-item')) {
                e.preventDefault();
                selectOption(document.activeElement);
            }
        }
    });

    // Close dropdowns on Turbo navigation and before cache snapshot
    document.addEventListener('turbo:before-visit', function () {
        closeAllDropdowns();
    });
    document.addEventListener('turbo:before-cache', function () {
        closeAllDropdowns();
    });
    window.addEventListener('blur', function () {
        closeAllDropdowns();
    });

    // Auto initialize dropdown state on DOM ready or Turbo load
    function initDropdowns() {
        document.querySelectorAll('.p3m-custom-dropdown').forEach(function (dropdown) {
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');
            if (hiddenInput && hiddenInput.value !== undefined) {
                const activeItem = dropdown.querySelector('.p3m-dropdown-item[data-value="' + hiddenInput.value + '"]');
                if (activeItem) {
                    const labelEl = dropdown.querySelector('.p3m-dropdown-label');
                    const displayLabel = activeItem.getAttribute('data-label') || activeItem.querySelector('.p3m-dropdown-item-text')?.textContent.trim() || activeItem.textContent.trim();
                    if (labelEl) labelEl.textContent = displayLabel;

                    dropdown.querySelectorAll('.p3m-dropdown-item').forEach(function (it) { it.classList.remove('active'); });
                    activeItem.classList.add('active');
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', initDropdowns);
    document.addEventListener('turbo:load', initDropdowns);
    document.addEventListener('turbo:render', initDropdowns);
})();
