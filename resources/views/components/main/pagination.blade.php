@if ($paginator->hasPages())

  @php
    if (!isset($scrollTo)) {
        $scrollTo = 'body';
    }

    $scrollIntoViewJsSnippet =
        $scrollTo !== false
            ? "(\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()"
            : '';
  @endphp
  <nav>
    <ul class="pagination">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
          <span aria-hidden="true">&lsaquo;</span>
        </li>
      @else
        <li>
          <button aria-label="@lang('pagination.previous')"
            x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:click="previousPage"
            rel="prev">&lsaquo;</button>
        </li>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
          <li class="disabled" aria-disabled="true">
            <span>{{ $element }}</span>
          </li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <li class="active" aria-current="page">
                <span>{{ $page }}</span>
              </li>
            @else
              <li><button x-on:click="{{ $scrollIntoViewJsSnippet }}"
                  wire:click="setPage({{ $page }})">{{ $page }}</button>
              </li>
            @endif
          @endforeach
        @endif
      @endforeach

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <li>
          <button aria-label="@lang('pagination.next')"
            x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:click="nextPage"
            rel="next">&rsaquo;</button>
        </li>
      @else
        <li class="disabled" aria-disabled="true"
          aria-label="@lang('pagination.next')">
          <span aria-hidden="true">&rsaquo;</span>
        </li>
      @endif
    </ul>
  </nav>
@endif
