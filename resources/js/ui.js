const qs = (selector, scope = document) => scope.querySelector(selector);
const qsa = (selector, scope = document) => Array.from(scope.querySelectorAll(selector));

export function showToast(message, type = 'success') {
    let stack = qs('[data-toast-stack]');

    if (!stack) {
        stack = document.createElement('div');
        stack.className = 'toast-stack';
        stack.dataset.toastStack = 'true';
        stack.setAttribute('aria-live', 'polite');
        document.body.appendChild(stack);
    }

    const toast = document.createElement('div');
    toast.className = `toast is-${type}`;
    toast.setAttribute('role', 'status');

    const icon = document.createElement('i');
    icon.dataset.lucide = type === 'error' ? 'circle-x' : 'circle-check';
    icon.className = 'mt-0.5 h-4 w-4 shrink-0';

    const text = document.createElement('span');
    text.className = 'leading-5';
    text.textContent = message;

    toast.append(icon, text);
    stack.appendChild(toast);
    window.refreshIcons?.();

    window.setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(6px)';
        window.setTimeout(() => toast.remove(), 220);
    }, 3600);
}

function initMobileMenu() {
    const toggles = qsa('[data-menu-toggle]');

    toggles.forEach((toggle) => {
        const menu = qs(toggle.dataset.menuToggle || '#publicMobileMenu');
        if (!menu) return;

        const close = () => {
            menu.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
        };

        toggle.addEventListener('click', (event) => {
            event.stopPropagation();
            const isOpen = menu.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', String(isOpen));
        });

        qsa('a', menu).forEach((link) => link.addEventListener('click', close));

        document.addEventListener('click', (event) => {
            if (!menu.contains(event.target) && !toggle.contains(event.target)) close();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') close();
        });
    });
}

function initSidebar() {
    const sidebar = qs('#appSidebar');
    const overlay = qs('#sidebarOverlay');
    if (!sidebar) return;

    const setOpen = (open) => {
        sidebar.classList.toggle('is-open', open);
        overlay?.classList.toggle('is-open', open);
        document.body.classList.toggle('overflow-hidden', open);
        qsa('[data-sidebar-toggle]').forEach((button) => button.setAttribute('aria-expanded', String(open)));
    };

    qsa('[data-sidebar-toggle]').forEach((toggle) => {
        toggle.addEventListener('click', (event) => {
            event.stopPropagation();
            setOpen(!sidebar.classList.contains('is-open'));
        });
    });

    overlay?.addEventListener('click', () => setOpen(false));

    qsa('a', sidebar).forEach((link) => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 1280) setOpen(false);
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') setOpen(false);
    });
}

function initDropdowns() {
    const dropdowns = qsa('[data-dropdown]');

    const closeAll = (except = null) => {
        dropdowns.forEach((dropdown) => {
            if (dropdown !== except) {
                dropdown.classList.remove('is-open');
                qs('[data-dropdown-toggle]', dropdown)?.setAttribute('aria-expanded', 'false');
            }
        });
    };

    dropdowns.forEach((dropdown) => {
        const toggle = qs('[data-dropdown-toggle]', dropdown);
        if (!toggle) return;

        toggle.addEventListener('click', (event) => {
            event.stopPropagation();
            const open = dropdown.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', String(open));
            closeAll(dropdown);
        });

        qsa('.dropdown-item', dropdown).forEach((item) => {
            item.addEventListener('click', () => closeAll());
        });
    });

    document.addEventListener('click', () => closeAll());
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeAll();
    });
}

function openDialog(dialog) {
    if (!dialog || typeof dialog.showModal !== 'function') return;
    dialog.showModal();
    document.body.classList.add('overflow-hidden');
    window.setTimeout(() => {
        qs('input:not([type="hidden"]), select, textarea', dialog)?.focus();
        window.refreshIcons?.();
    }, 80);
}

function closeDialog(dialog) {
    if (!dialog) return;
    dialog.close();
    if (!qs('dialog[open]')) {
        document.body.classList.remove('overflow-hidden');
    }
}

function initModals() {
    qsa('[data-modal-open]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const dialog = document.getElementById(trigger.dataset.modalOpen);
            if (!dialog) return;

            if (trigger.dataset.resetForm !== undefined) {
                const form = qs('form', dialog);
                form?.reset();
            }

            if (trigger.dataset.modalTitleText) {
                const title = qs('[data-modal-title]', dialog);
                if (title) title.textContent = trigger.dataset.modalTitleText;
            }

            openDialog(dialog);
        });
    });

    qsa('dialog').forEach((dialog) => {
        qsa('[data-modal-close]', dialog).forEach((button) => {
            button.addEventListener('click', () => closeDialog(dialog));
        });

        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) closeDialog(dialog);
        });

        dialog.addEventListener('close', () => {
            if (!qs('dialog[open]')) {
                document.body.classList.remove('overflow-hidden');
            }
        });
    });

    qsa('form[data-demo-form]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const message = form.dataset.successMessage || 'Data berhasil disimpan (mode demo).';
            const dialog = form.closest('dialog');
            if (dialog) closeDialog(dialog);
            form.reset();
            qsa('[data-star-value]', form).forEach((star) => star.classList.remove('is-selected'));
            showToast(message);
        });
    });

    qsa('[data-edit-record]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const dialog = document.getElementById(trigger.dataset.editModal);
            if (!dialog) return;
            const form = qs('form', dialog);

            Object.entries(trigger.dataset).forEach(([key, value]) => {
                if (['editRecord', 'editModal', 'editTitle'].includes(key) || !form) return;
                const field = form.elements[key];
                if (!field) return;
                if (field.type === 'checkbox') {
                    field.checked = value === '1' || value === 'true';
                } else {
                    field.value = value;
                }
            });

            const title = qs('[data-modal-title]', dialog);
            if (title && trigger.dataset.editTitle) title.textContent = trigger.dataset.editTitle;

            openDialog(dialog);
        });
    });

    let deleteTarget = null;
    const deleteDialog = qs('#deleteModal');

    qsa('[data-delete-trigger]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            deleteTarget = trigger.closest('[data-row]');
            const name = trigger.dataset.name || 'data ini';
            const nameTarget = qs('[data-delete-name]', deleteDialog || document);
            if (nameTarget) nameTarget.textContent = name;
            openDialog(deleteDialog);
        });
    });

    qs('[data-delete-confirm]')?.addEventListener('click', () => {
        if (deleteTarget) {
            deleteTarget.remove();
            window.PetCareTables?.refreshAll();
        }
        deleteTarget = null;
        closeDialog(deleteDialog);
        showToast('Data berhasil dihapus (mode demo).');
    });
}

function initTabs() {
    qsa('[data-tabs]').forEach((root) => {
        const buttons = qsa('[data-tab-target]', root);
        const panels = qsa('[data-tab-panel]', root);

        const activate = (target, updateHash = false) => {
            buttons.forEach((button) => {
                const active = button.dataset.tabTarget === target;
                button.classList.toggle('is-active', active);
                button.setAttribute('aria-selected', String(active));
            });
            panels.forEach((panel) => {
                panel.classList.toggle('is-active', panel.dataset.tabPanel === target);
            });
            if (updateHash) history.replaceState(null, '', `#${target}`);
        };

        buttons.forEach((button) => {
            button.addEventListener('click', () => activate(button.dataset.tabTarget, true));
        });

        const hash = window.location.hash.replace('#', '');
        if (hash && buttons.some((button) => button.dataset.tabTarget === hash)) {
            activate(hash);
        }
    });
}

function initRecordDemoActions() {
    qsa('[data-booking-action]').forEach((button) => {
        button.addEventListener('click', () => {
            const action = button.dataset.bookingAction;
            const badge = qs('[data-booking-status]');
            const map = {
                confirm: { label: 'Dikonfirmasi', className: 'badge-sky' },
                start: { label: 'Sedang Dikerjakan', className: 'badge-amber' },
                finish: { label: 'Selesai', className: 'badge-mint' },
                cancel: { label: 'Dibatalkan', className: 'badge-rose' },
            };
            const target = map[action];

            if (badge && target) {
                badge.className = `badge ${target.className}`;
                badge.innerHTML = `<span class="badge-dot"></span>${target.label}`;
            }

            const timelineMap = { confirm: 1, start: 2, finish: 3, cancel: 0 };
            qsa('[data-timeline-step]').forEach((item) => {
                const step = Number(item.dataset.timelineStep);
                item.classList.toggle('is-done', step <= (timelineMap[action] || 0));
                item.classList.toggle('is-current', step === timelineMap[action]);
            });

            qsa('[data-booking-action]').forEach((item) => {
                if (item === button) {
                    item.disabled = true;
                    item.classList.add('opacity-50');
                }

                if (action === 'confirm' && item.dataset.bookingAction === 'start') item.disabled = false;
                if (action === 'start' && item.dataset.bookingAction === 'finish') item.disabled = false;
                if (action === 'cancel') {
                    item.disabled = true;
                    item.classList.add('opacity-50');
                }
            });

            const messages = {
                confirm: 'Booking berhasil dikonfirmasi (mode demo).',
                start: 'Perawatan dimulai. Status diperbarui (mode demo).',
                finish: 'Perawatan selesai. Status diperbarui (mode demo).',
                cancel: 'Booking dibatalkan (mode demo).',
            };
            showToast(messages[action] || 'Status diperbarui.');
        });
    });

    qsa('[data-payment-action]').forEach((button) => {
        button.addEventListener('click', () => {
            const row = button.closest('[data-row]');
            const badge = qs('[data-payment-badge]', row || document);
            const verify = button.dataset.paymentAction === 'verify';

            if (badge) {
                badge.className = `badge ${verify ? 'badge-mint' : 'badge-rose'}`;
                badge.innerHTML = `<span class="badge-dot"></span>${verify ? 'Dibayar' : 'Ditolak'}`;
            }

            const actions = qs('[data-payment-actions]', row || document);
            if (actions) {
                actions.innerHTML = '<span class="text-[10px] font-bold text-slate-400">Selesai diverifikasi</span>';
            }

            if (row) row.dataset.payment = verify ? 'dibayar' : 'ditolak';

            showToast(verify ? 'Pembayaran berhasil diverifikasi (mode demo).' : 'Pembayaran ditolak (mode demo).', verify ? 'success' : 'error');
        });
    });
}

function initStarRating() {
    qsa('[data-star-rating]').forEach((group) => {
        const input = qs('input[name="rating"]', group);
        const stars = qsa('[data-star-value]', group);

        const setValue = (value) => {
            if (input) input.value = String(value);
            stars.forEach((star) => {
                const active = Number(star.dataset.starValue) <= value;
                star.classList.toggle('text-amber-400', active);
                star.classList.toggle('fill-current', active);
                star.classList.toggle('text-slate-300', !active);
                star.setAttribute('aria-pressed', String(Number(star.dataset.starValue) === value));
            });
        };

        stars.forEach((star) => {
            star.addEventListener('click', () => setValue(Number(star.dataset.starValue)));
            star.addEventListener('mouseenter', () => {
                stars.forEach((item) => {
                    const active = Number(item.dataset.starValue) <= Number(star.dataset.starValue);
                    item.classList.toggle('text-amber-400', active);
                    item.classList.toggle('text-slate-300', !active);
                });
            });
        });

        group.addEventListener('mouseleave', () => setValue(Number(input?.value || 5)));
        group._setStarValue = setValue;
        setValue(Number(input?.value || 5));
    });
}

function initReviewForm() {
    const form = qs('form[data-review-form]');
    if (!form) return;

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const service = form.querySelector('[name="service"]')?.value || 'Layanan PetCare';
        const rating = Number(form.querySelector('[name="rating"]')?.value || 5);
        const text = form.querySelector('[name="review"]')?.value?.trim() || '';
        const today = form.dataset.today || new Date().toLocaleDateString('id-ID');
        const list = qs('#reviewList');
        const dialog = form.closest('dialog');

        if (!text) {
            showToast('Tuliskan ulasan terlebih dahulu.', 'error');
            return;
        }

        if (list) {
            const card = document.createElement('article');
            card.className = 'testimonial-card';
            card.dataset.row = 'true';

            const head = document.createElement('div');
            head.className = 'flex items-start gap-3';

            const avatar = document.createElement('div');
            avatar.className = 'avatar avatar-md avatar-mint';
            avatar.textContent = 'RP';

            const meta = document.createElement('div');
            meta.className = 'min-w-0 flex-1';
            const name = document.createElement('p');
            name.className = 'text-sm font-extrabold text-ink';
            name.textContent = 'Rina Pratama';
            const detail = document.createElement('p');
            detail.className = 'mt-0.5 text-[10px] font-semibold text-slate-400';
            detail.textContent = `${service} · ${today}`;
            meta.append(name, detail);

            const stars = document.createElement('div');
            stars.className = 'rating-stars ml-auto shrink-0';
            stars.setAttribute('aria-label', `${rating} dari 5 bintang`);
            stars.textContent = '★'.repeat(rating) + '☆'.repeat(5 - rating);

            head.append(avatar, meta, stars);

            const copy = document.createElement('p');
            copy.className = 'mt-3 text-xs font-medium leading-6 text-slate-600';
            copy.textContent = text;

            const footer = document.createElement('div');
            footer.className = 'mt-3 flex items-center gap-1.5 border-t border-slate-100 pt-3 text-[9px] font-bold text-primary-600';
            footer.innerHTML = '<i data-lucide="badge-check" class="h-3.5 w-3.5"></i><span>Ulasan terverifikasi</span>';

            card.append(head, copy, footer);
            list.prepend(card);
            window.refreshIcons?.();
        }

        closeDialog(dialog);
        form.reset();
        qsa('[data-star-value]', form).forEach((star) => star.classList.remove('is-selected'));
        form.querySelector('[data-star-rating]')?._setStarValue?.(5);
        showToast('Ulasan berhasil ditambahkan (mode demo).');
    });
}

function initCopyButtons() {
    qsa('[data-copy]').forEach((button) => {
        button.addEventListener('click', async () => {
            const value = button.dataset.copy || button.textContent.trim();
            try {
                await navigator.clipboard.writeText(value);
                showToast('Berhasil disalin ke clipboard.');
            } catch {
                showToast('Browser tidak mengizinkan penyalinan otomatis.', 'error');
            }
        });
    });
}

function initFavorites() {
    qsa('[data-favorite]').forEach((button) => {
        button.setAttribute('aria-pressed', 'false');
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const active = button.classList.toggle('is-favorite');
            button.setAttribute('aria-pressed', String(active));
            button.classList.toggle('text-rose-500', active);
            showToast(active ? 'Ditambahkan ke favorit (mode demo).' : 'Dihapus dari favorit (mode demo).');
        });
    });
}

function initPrintAndExport() {
    qsa('[data-print]').forEach((button) => {
        button.addEventListener('click', () => window.print());
    });

    qsa('[data-export-csv]').forEach((button) => {
        button.addEventListener('click', () => {
            const table = qs(button.dataset.exportCsv);
            if (!table) return;

            const rows = [];
            qsa('tr', table).forEach((row) => {
                const cells = qsa('th, td', row)
                    .filter((cell) => cell.offsetParent !== null)
                    .map((cell) => `"${cell.innerText.replace(/"/g, '""').replace(/\n/g, ' ')}"`);
                if (cells.length) rows.push(cells.join(','));
            });

            const blob = new Blob([`\uFEFF${rows.join('\n')}`], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `petcare-laporan-${new Date().toISOString().slice(0, 10)}.csv`;
            link.click();
            URL.revokeObjectURL(url);
            showToast('Laporan CSV berhasil diunduh.');
        });
    });
}

function initFileInputs() {
    qsa('input[type="file"][data-file-name]').forEach((input) => {
        input.addEventListener('change', () => {
            const target = qs(input.dataset.fileName);
            if (target) target.textContent = input.files?.[0]?.name || 'Belum ada file dipilih';
        });
    });
}

function initServiceFilters() {
    qsa('[data-service-filter-scope]').forEach((scope) => {
        const search = qs('[data-service-search]', scope);
        const chips = qsa('[data-service-chip]', scope);
        const items = qsa('[data-service-item]', scope);
        const empty = qs('[data-service-empty]', scope);
        let category = 'semua';

        const apply = () => {
            const query = (search?.value || '').trim().toLowerCase();
            let visible = 0;

            items.forEach((item) => {
                const matchesQuery = (item.dataset.search || item.textContent).toLowerCase().includes(query);
                const matchesCategory = category === 'semua' || item.dataset.category === category;
                const show = matchesQuery && matchesCategory;
                item.classList.toggle('hidden', !show);
                if (show) visible += 1;
            });

            if (empty) empty.classList.toggle('hidden', visible !== 0);
        };

        search?.addEventListener('input', apply);

        chips.forEach((chip) => {
            chip.addEventListener('click', () => {
                chips.forEach((item) => item.classList.remove('is-active'));
                chip.classList.add('is-active');
                category = chip.dataset.serviceChip || 'semua';
                apply();
            });
        });
    });
}

function initScrollRows() {
    qsa('[data-scroll-target]').forEach((button) => {
        button.addEventListener('click', () => {
            const target = qs(button.dataset.scrollTarget);
            if (!target) return;
            const direction = button.dataset.scrollDir === 'left' ? -1 : 1;
            target.scrollBy({ left: direction * 320, behavior: 'smooth' });
        });
    });
}

function initReveal() {
    const elements = qsa('.reveal');
    if (!elements.length) return;

    if (!('IntersectionObserver' in window)) {
        elements.forEach((element) => element.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    elements.forEach((element) => observer.observe(element));
}

export function initUI() {
    initMobileMenu();
    initSidebar();
    initDropdowns();
    initModals();
    initTabs();
    initRecordDemoActions();
    initStarRating();
    initReviewForm();
    initCopyButtons();
    initFavorites();
    initPrintAndExport();
    initFileInputs();
    initServiceFilters();
    initScrollRows();
    initReveal();
}
