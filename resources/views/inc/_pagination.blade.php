@if ($results->lastPage() > 1)
    <div class="pagination">
        @if ($results->currentPage() > 1)
            <a class="pagination-previous" href="{{ $results->appends(request()->query())->previousPageUrl() }}"></a>
        @else
            <a class="pagination-previous" disabled></a>
        @endif

        <span class="page-number">Página {{ $results->currentPage() }}</span>

        @if ($results->currentPage() < $results->lastPage())
            <a class="pagination-next" href="{{ $results->appends(request()->query())->nextPageUrl() }}"></a>
        @else
            <a class="pagination-next" disabled></a>
        @endif
    </div>
@endif
