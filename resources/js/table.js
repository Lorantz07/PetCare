function initTable(wrapper) {
    const table = wrapper.querySelector('table');
    if (!table) return;

    const tbody = table.querySelector('tbody');
    const search = wrapper.querySelector('[data-table-search]');
    const filters = Array.from(wrapper.querySelectorAll('[data-table-filter]'));
    const info = wrapper.querySelector('[data-table-info]');
    const pagination = wrapper.querySelector('[data-table-pagination]');
    const pageSize = Number(wrapper.dataset.pageSize || 6);
    let page = 1;

    if (!tbody) return;

    const getRows = () => Array.from(tbody.querySelectorAll('tr[data-row]'));

    const getEmptyRow = () => {
        let empty = tbody.querySelector('[data-empty-row]');

        if (!empty) {
            const columnCount = table.querySelectorAll('thead th').length || 1;
            empty = document.createElement('tr');
            empty.dataset.emptyRow = 'true';
            empty.innerHTML = `<td colspan="${columnCount}" style="text-align:center; padding: 2rem 1rem; color:#94a3b8; font-weight:600;">Tidak ada data yang cocok dengan pencarian.</td>`;
            tbody.appendChild(empty);
        }

        return empty;
    };

    const renderPagination = (totalPages) => {
        if (!pagination) return;

        pagination.innerHTML = '';

        const makeButton = (label, targetPage, options = {}) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = `page-btn${options.active ? ' is-active' : ''}`;
            button.innerHTML = label;
            button.disabled = Boolean(options.disabled);
            button.setAttribute('aria-label', options.ariaLabel || `Halaman ${targetPage}`);
            if (options.active) button.setAttribute('aria-current', 'page');
            button.addEventListener('click', () => {
                page = targetPage;
                render();
            });
            return button;
        };

        pagination.appendChild(makeButton('&lsaquo;', Math.max(1, page - 1), {
            disabled: page === 1,
            ariaLabel: 'Halaman sebelumnya',
        }));

        for (let index = 1; index <= totalPages; index += 1) {
            pagination.appendChild(makeButton(String(index), index, { active: index === page }));
        }

        pagination.appendChild(makeButton('&rsaquo;', Math.min(totalPages, page + 1), {
            disabled: page === totalPages || totalPages === 0,
            ariaLabel: 'Halaman berikutnya',
        }));
    };

    const render = () => {
        const rows = getRows();
        const query = (search?.value || '').trim().toLowerCase();
        const activeFilters = filters
            .map((filter) => ({
                key: filter.dataset.filterKey || '',
                value: (filter.value || '').trim().toLowerCase(),
            }))
            .filter((filter) => filter.value !== '');

        const filtered = rows.filter((row) => {
            const searchable = (row.dataset.search || row.textContent).toLowerCase();

            if (query && !searchable.includes(query)) return false;

            return activeFilters.every((filter) => {
                if (filter.key) {
                    return String(row.dataset[filter.key] || '').toLowerCase() === filter.value;
                }

                return row.textContent.toLowerCase().includes(filter.value);
            });
        });

        const hasPagination = Boolean(pagination);
        const perPage = hasPagination ? pageSize : Math.max(filtered.length, 1);
        const totalPages = Math.max(1, Math.ceil(filtered.length / perPage));

        if (page > totalPages) page = totalPages;

        rows.forEach((row) => {
            row.style.display = 'none';
        });

        filtered.slice((page - 1) * perPage, page * perPage).forEach((row) => {
            row.style.display = '';
        });

        const empty = getEmptyRow();
        empty.style.display = filtered.length === 0 ? '' : 'none';

        if (info) {
            if (filtered.length === 0) {
                info.textContent = 'Tidak ada data';
            } else {
                const start = (page - 1) * perPage + 1;
                const end = Math.min(page * perPage, filtered.length);
                info.textContent = `Menampilkan ${start}–${end} dari ${filtered.length} data`;
            }
        }

        if (pagination) {
            renderPagination(totalPages);
        }
    };

    if (search) {
        let timer;
        search.addEventListener('input', () => {
            window.clearTimeout(timer);
            timer = window.setTimeout(() => {
                page = 1;
                render();
            }, 100);
        });
    }

    filters.forEach((filter) => {
        filter.addEventListener('change', () => {
            page = 1;
            render();
        });
    });

    wrapper._petcareTableRender = render;
    render();
}

export function initTables() {
    const wrappers = Array.from(document.querySelectorAll('[data-table]'));
    wrappers.forEach(initTable);

    window.PetCareTables = {
        refreshAll() {
            wrappers.forEach((wrapper) => wrapper._petcareTableRender?.());
        },
        refresh(wrapper) {
            wrapper?._petcareTableRender?.();
        },
    };
}
