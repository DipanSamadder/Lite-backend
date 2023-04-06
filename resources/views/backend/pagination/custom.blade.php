@if ($paginator->hasPages())
<ul class="pagination pagination-primary mt-4 d-flex align-items-center">
    @if ($paginator->onFirstPage())
        <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">← </a></li>
    @else
        <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev">← </a></li>
    @endif
    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">{{ $element }}</a></li>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active"><a class="page-link" href="javascript:void(0);">{{ $page }}</a></li>
                @else
                    <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next"> →</a></li>
    @else
        <li class="page-item disabled"><a class="page-link" href="javascript:void(0);"> →</a></li>
    @endif
</ul>
@endif 
