<x-layouts.main body_name="page">
  <x-breadcrumbs :list="[ ['Страница', null]]" />
  {{--  --}}
  <section class="page__section">
    <div class="page__container container">
      <div class="page__title title">
        <h1>Страницы сайта</h1>
      </div>
      <div class="page__prose prose">
        <ol>
          <li><a href="/index">Главная [index]</a></li>
          <li><a href="/catalog">Каталог [catalog]</a></li>
          <li><a href="/product">Товар [product]</a></li>
          <li><a href="/cart">Корзина [cart]</a></li>
          <li><a href="/checkout">Оформление заказа [checkout]</a></li>
          <li><a href="/loyalty">Бонусная программа [loyalty]</a></li>
          <li><a href="/articles">Статьи [articles]</a></li>
          <li><a href="/about">О нас [about]</a></li>
          <li><a href="/contacts">Контакты [contacts]</a></li>
          <li><a href="/page">Страница [page]</a></li>
          <li><a href="/account-index">Профиль [account-index]</a></li>
          <li><a href="/account-edit">Редактирование [account-edit]</a></li>
          <li><a href="/account-addresses">Адреса [account-addresses]</a></li>
          <li>
            <a href="/account-favorites">Избранное [account-favorites]</a>
          </li>
          <li><a href="/account-loyalty">Бонусы [account-loyalty]</a></li>
          <li><a href="/account-orders">Заказы [account-orders]</a></li>
        </ol>
      </div>
    </div>
  </section>
</x-layouts.main>
