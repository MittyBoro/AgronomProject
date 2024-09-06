<div
  class="fi-panel"
  x-data="{
    $find: (name) => {
      return window.Livewire.all().find((cmp) => cmp.name === name)
    },
    links: [
      {
        component: 'catalog-page',
        title: 'Редактировать категорию',
        path: 'categories',
        property: 'categoryId',
      },
      {
        component: 'product-page',
        title: 'Редактировать товар',
        path: 'products',
        property: 'productId',
      },
      {
        component: 'article-page',
        title: 'Редактировать статью',
        path: 'articles',
        property: 'articleId',
      },
    ],
    items: {},
    async init() {
      await new Promise((resolve) => {
        window.addEventListener('load', resolve)
        document.addEventListener('livewire:navigated', resolve, { once: true })
        setTimeout(resolve, 1000)
      })

      for (const link of this.links) {
        this.items[link.component] = this.$find(link.component)?.$wire?.get(
          link.property,
        )
      }
    },
  }"
>
  <div class="container fi-container">
    <a
      class="fi-home"
      href="{{ route('filament.theadmin.pages.dashboard') }}"
      target="_blank"
      wire:ignore
    >
      <span>Панель</span>
      <span>Управления</span>
    </a>

    {{-- Категория --}}
    <template x-for="link in links">
      <template x-if="items[link.component]">
        <a
          target="_blank"
          :href="`/@theadmin/${link.path}/${items[link.component]}/edit`"
          x-text="link.title"
        ></a>
      </template>
    </template>
  </div>

  <style>
    .fi-panel {
      background: #111;
      color: #fff;
      font-size: 13px;
      z-index: 1000;
    }
    .fi-panel a {
      padding: 5px 0;
    }
    .fi-panel a:hover {
      color: var(--primary-color);
      transition: color 0.15s;
    }

    .fi-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
    }
    .fi-home {
      display: grid;
      margin-right: auto;
      font-weight: 700;
      font-size: 11px;
      line-height: 1.1;
      letter-spacing: 0.05em;
    }
    .fi-home span:first-letter {
      color: var(--primary-color);
    }
  </style>
</div>
