@php
  if (! isset($scrollTo)) {
    $scrollTo = 'body';
  }

  $scrollIntoViewJsSnippet = $scrollTo !== false ? "(\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()" : '';
@endphp

<nav>
  @if ($paginator->hasPages())
    <ul class="pagination">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <li
          class="page-item disabled"
          aria-disabled="true"
          aria-label="@lang('pagination.previous')"
        >
          <span class="page-link" aria-hidden="true">&lsaquo;</span>
        </li>
      @else
        <li class="page-item">
          <button
            class="page-link"
            type="button"
            aria-label="@lang('pagination.previous')"
            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
            wire:click="previousPage('{{ $paginator->getPageName() }}')"
            x-on:click="{{ $scrollIntoViewJsSnippet }}"
            wire:loading.attr="disabled"
          >
            &lsaquo;
          </button>
        </li>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
          <li class="page-item disabled" aria-disabled="true">
            <span class="page-link">{{ $element }}</span>
          </li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <li
                class="page-item active"
                aria-current="page"
                wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}"
              >
                <span class="page-link">{{ $page }}</span>
              </li>
            @else
              <li
                class="page-item"
                wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}"
              >
                <button
                  class="page-link"
                  type="button"
                  wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                  x-on:click="{{ $scrollIntoViewJsSnippet }}"
                >
                  {{ $page }}
                </button>
              </li>
            @endif
          @endforeach
        @endif
      @endforeach

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <li class="page-item">
          <button
            class="page-link"
            type="button"
            aria-label="@lang('pagination.next')"
            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
            wire:click="nextPage('{{ $paginator->getPageName() }}')"
            x-on:click="{{ $scrollIntoViewJsSnippet }}"
            wire:loading.attr="disabled"
          >
            &rsaquo;
          </button>
        </li>
      @else
        <li
          class="page-item disabled"
          aria-disabled="true"
          aria-label="@lang('pagination.next')"
        >
          <span class="page-link" aria-hidden="true">&rsaquo;</span>
        </li>
      @endif
    </ul>
  @endif
</nav>
