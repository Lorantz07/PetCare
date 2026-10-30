function formatRupiah(value) {
    return `Rp ${Number(value || 0).toLocaleString('id-ID')}`;
}

export function initBookingWizard() {
    const wizard = document.querySelector('#bookingWizard');
    if (!wizard) return;

    const steps = Array.from(wizard.querySelectorAll('[data-booking-step]'));
    const panels = Array.from(wizard.querySelectorAll('[data-booking-panel]'));
    const errorBox = wizard.querySelector('[data-booking-error]');
    const successUrl = wizard.dataset.successUrl || '/pelanggan/booking/sukses';
    const preselected = wizard.dataset.preselectedService || '';
    const preselectedPet = wizard.dataset.preselectedPet || '';

    const state = {
        step: 1,
        service: '',
        serviceName: '',
        servicePrice: 0,
        serviceUnit: 'sesi',
        date: '',
        dateLabel: '',
        time: '',
        pet: '',
        method: '',
        notes: '',
    };

    const setError = (message) => {
        if (!errorBox) return;
        const target = errorBox.querySelector('p') || errorBox;
        target.textContent = message;
        errorBox.classList.toggle('hidden', !message);
        if (message) errorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    };

    const clearError = () => setError('');

    const setSummary = () => {
        const serviceLabel = state.serviceName || 'Belum dipilih';
        const total = state.servicePrice || 0;

        wizard.querySelectorAll('[data-summary-service]').forEach((element) => {
            element.textContent = serviceLabel;
        });
        wizard.querySelectorAll('[data-summary-service-price]').forEach((element) => {
            element.textContent = serviceLabel === 'Belum dipilih' ? '—' : formatRupiah(total);
        });
        wizard.querySelectorAll('[data-summary-date]').forEach((element) => {
            element.textContent = state.dateLabel || 'Belum dipilih';
        });
        wizard.querySelectorAll('[data-summary-time]').forEach((element) => {
            element.textContent = state.time || 'Belum dipilih';
        });
        wizard.querySelectorAll('[data-summary-pet]').forEach((element) => {
            element.textContent = state.pet || 'Belum dipilih';
        });
        wizard.querySelectorAll('[data-summary-method]').forEach((element) => {
            element.textContent = state.method || 'Belum dipilih';
        });
        wizard.querySelectorAll('[data-summary-total]').forEach((element) => {
            element.textContent = formatRupiah(total);
        });
        wizard.querySelectorAll('[data-summary-unit]').forEach((element) => {
            element.textContent = state.serviceUnit;
        });
    };

    const showStep = (step, scroll = true) => {
        state.step = step;

        panels.forEach((panel) => {
            panel.classList.toggle('is-active', Number(panel.dataset.bookingPanel) === step);
        });

        steps.forEach((item) => {
            const number = Number(item.dataset.bookingStep);
            item.classList.toggle('is-active', number === step);
            item.classList.toggle('is-done', number < step);
        });

        clearError();

        if (scroll) {
            wizard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };

    const selectedServiceInput = () => wizard.querySelector('input[name="service"]:checked');
    const selectedPetInput = () => wizard.querySelector('input[name="pet"]:checked');
    const selectedMethodInput = () => wizard.querySelector('input[name="payment_method"]:checked');

    const applyService = (input) => {
        if (!input) return;
        state.service = input.value;
        state.serviceName = input.dataset.serviceName || input.value;
        state.servicePrice = Number(input.dataset.servicePrice || 0);
        state.serviceUnit = input.dataset.serviceUnit || 'sesi';
        setSummary();
    };

    wizard.querySelectorAll('input[name="service"]').forEach((input) => {
        input.addEventListener('change', () => {
            if (input.checked) {
                applyService(input);
                clearError();
            }
        });
    });

    wizard.querySelectorAll('[data-day]').forEach((button) => {
        button.addEventListener('click', () => {
            if (button.disabled) return;

            wizard.querySelectorAll('[data-day]').forEach((item) => item.classList.remove('is-selected'));
            button.classList.add('is-selected');
            state.date = button.dataset.day;
            state.dateLabel = button.dataset.dayLabel || button.dataset.day;
            state.time = '';

            wizard.querySelectorAll('[data-time]').forEach((item) => item.classList.remove('is-selected'));
            setSummary();
            clearError();
        });
    });

    wizard.querySelectorAll('[data-time]').forEach((button) => {
        button.addEventListener('click', () => {
            if (button.disabled) return;

            wizard.querySelectorAll('[data-time]').forEach((item) => item.classList.remove('is-selected'));
            button.classList.add('is-selected');
            state.time = button.dataset.time;
            setSummary();
            clearError();
        });
    });

    wizard.querySelectorAll('input[name="pet"]').forEach((input) => {
        input.addEventListener('change', () => {
            if (input.checked) {
                state.pet = input.value;
                setSummary();
                clearError();
            }
        });
    });

    wizard.querySelectorAll('input[name="payment_method"]').forEach((input) => {
        input.addEventListener('change', () => {
            if (input.checked) {
                state.method = input.dataset.methodLabel || input.value;
                setSummary();
                clearError();
            }
        });
    });

    wizard.querySelectorAll('[data-booking-next]').forEach((button) => {
        button.addEventListener('click', () => {
            if (state.step === 1) {
                const service = selectedServiceInput();
                if (!service) {
                    setError('Pilih layanan terlebih dahulu sebelum melanjutkan.');
                    return;
                }
                applyService(service);
            }

            if (state.step === 2) {
                if (!state.date) {
                    setError('Pilih tanggal kunjungan terlebih dahulu.');
                    return;
                }
                if (!state.time) {
                    setError('Pilih jam kunjungan yang tersedia.');
                    return;
                }
            }

            if (state.step === 3) {
                const pet = selectedPetInput();
                if (!pet) {
                    setError('Pilih hewan yang akan dirawat.');
                    return;
                }
                state.pet = pet.value;
            }

            showStep(Math.min(state.step + 1, 4));
        });
    });

    wizard.querySelectorAll('[data-booking-prev]').forEach((button) => {
        button.addEventListener('click', () => showStep(Math.max(state.step - 1, 1)));
    });

    const notes = wizard.querySelector('[data-booking-notes]');
    if (notes) {
        notes.addEventListener('input', () => {
            state.notes = notes.value;
        });
    }

    const confirmButton = wizard.querySelector('[data-booking-confirm]');
    if (confirmButton) {
        confirmButton.addEventListener('click', () => {
            const method = selectedMethodInput();
            const terms = wizard.querySelector('input[name="terms"]');

            if (!method) {
                setError('Pilih metode pembayaran terlebih dahulu.');
                return;
            }

            if (!terms?.checked) {
                setError('Centang persetujuan syarat dan ketentuan untuk melanjutkan.');
                return;
            }

            state.method = method.dataset.methodLabel || method.value;
            setSummary();

            const params = new URLSearchParams({
                service: state.service,
                date_label: state.dateLabel,
                time: state.time,
                pet: state.pet,
                method: state.method,
                total: String(state.servicePrice),
            });

            confirmButton.disabled = true;
            confirmButton.innerHTML = 'Memproses booking...';

            window.setTimeout(() => {
                window.location.href = `${successUrl}?${params.toString()}`;
            }, 450);
        });
    }

    if (preselected) {
        const input = wizard.querySelector(`input[name="service"][value="${preselected}"]`);
        if (input) {
            input.checked = true;
            applyService(input);
        }
    }

    if (preselectedPet) {
        const petInput = Array.from(wizard.querySelectorAll('input[name="pet"]'))
            .find((input) => input.value.toLowerCase() === preselectedPet.toLowerCase());

        if (petInput) {
            petInput.checked = true;
            state.pet = petInput.value;
        }
    }

    setSummary();
    showStep(1, false);
}
