@if ($paginator->hasPages())
   <!--Pagination -->
   <nav class="mb-4">
        <ul class="pagination pagination-circle pg-red mb-0">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"> 
                <span aria-hidden="true">«</span>
                <span class="sr-only">Anterior</span>
            </li>
        @else
            <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}"  class="page-link waves-effect waves-effect" aria-label="Anterior">
                            <span aria-hidden="true">«</span>
                            <span class="sr-only">Anterior</span>
                        </a> 
                    </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link waves-effect waves-effect">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link waves-effect waves-effect" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link waves-effect waves-effect" aria-label="Next">
                            <span aria-hidden="true">»</span>
                            <span class="sr-only">Siguiente</span>
                        </a>
</li>
        @else
            <li class="page-item disabled"><span aria-hidden="true">»</span>
                <span class="sr-only">Siguiente</span></li>
        @endif
   
    </ul>
</nav>
@endif


