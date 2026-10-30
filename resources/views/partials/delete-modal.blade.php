<x-modal id="deleteModal" title="Hapus data?" subtitle="Tindakan ini tidak dapat dibatalkan. Data demo akan dihapus dari tampilan." size="sm">
    <div class="rounded-xl border border-rose-100 bg-rose-50/70 p-3.5">
        <p class="text-xs font-semibold leading-5 text-rose-700">Anda akan menghapus <strong data-delete-name>data ini</strong> dari daftar demo.</p>
    </div>
    <div class="mt-4 flex justify-end gap-2">
        <button type="button" class="btn btn-secondary btn-sm" data-modal-close>Batal</button>
        <button type="button" class="btn btn-danger btn-sm" data-delete-confirm>
            <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
            Ya, hapus
        </button>
    </div>
</x-modal>
