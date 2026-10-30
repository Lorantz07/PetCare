@props(['id', 'title' => null, 'subtitle' => null, 'size' => 'md', 'titleAttribute' => false])

@php
    $sizeClass = match ($size) {
        'sm' => 'max-w-md',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        default => 'max-w-lg',
    };
@endphp

<dialog id="{{ $id }}" class="modal {{ $sizeClass }}" @if ($subtitle) aria-describedby="{{ $id }}-description" @endif>
    <div class="modal-card">
        <div class="modal-head">
            <div>
                @if ($title)
                    <h2 class="modal-title" @if ($titleAttribute) data-modal-title @endif>{{ $title }}</h2>
                @endif
                @if ($subtitle)
                    <p id="{{ $id }}-description" class="modal-copy">{{ $subtitle }}</p>
                @endif
            </div>
            <button type="button" class="btn-icon -mt-1 shrink-0" data-modal-close aria-label="Tutup dialog">
                <i data-lucide="x" class="h-4 w-4"></i>
            </button>
        </div>

        {{ $slot }}
    </div>
</dialog>
