@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex justify-center mt-4">
        <ul class="inline-flex items-center space-x-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-2 text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
                        &laquo;
                    </span>
                </li>
            @else
                <li>
                    <button wire:click="previousPage('{{ $paginator->getPageName() }}')" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded hover:bg-blue-100 hover:text-blue-700 cursor-pointer">
                        &laquo;
                    </button>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-2 text-gray-500">...</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="px-3 py-2 text-white bg-blue-600 border border-blue-600 rounded font-bold cursor-default">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <button wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded hover:bg-blue-100 hover:text-blue-700 cursor-pointer">
                                    {{ $page }}
                                </button>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <button wire:click="nextPage('{{ $paginator->getPageName() }}')" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded hover:bg-blue-100 hover:text-blue-700 cursor-pointer">
                        &raquo;
                    </button>
                </li>
            @else
                <li>
                    <span class="px-3 py-2 text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
                        &raquo;
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif