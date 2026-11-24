@if ($paginator->hasPages())
    <div class="inline-form" style="justify-content:space-between">
        <small>Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</small>
        <div class="actions">
            @if ($paginator->onFirstPage())
                <span class="btn btn-ghost btn-sm" style="opacity:.5">Sebelumnya</span>
            @else
                <a class="btn btn-outline btn-sm" href="{{ $paginator->previousPageUrl() }}">Sebelumnya</a>
            @endif
            @if ($paginator->hasMorePages())
                <a class="btn btn-outline btn-sm" href="{{ $paginator->nextPageUrl() }}">Berikutnya</a>
            @else
                <span class="btn btn-ghost btn-sm" style="opacity:.5">Berikutnya</span>
            @endif
        </div>
    </div>
@endif
