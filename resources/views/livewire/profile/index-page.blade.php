<div class="profile-index">
  {{-- дратути --}}
  <div class="profile-index__greeting">
    <p>
      Здравствуйте,
      <b>{{ trim($user->first_name . ' ' . $user->middle_name) }},</b>
      добро пожаловать в личный кабинет!
    </p>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button class="button button-alt button-mini">Выйти из аккаунта</button>
    </form>
  </div>

  {{-- общая информация --}}
  <div class="profile-index__info profile__card">
    <div class="profile-index__title profile__title">
      Ваша личная информация
    </div>
    {{--  --}}
    <div class="profile-index__info-line profile__info-line">
      <div class="profile-index__info-title profile__info-title">
        Публичное имя
      </div>
      <div class="profile-index__info-text profile__info-text">
        {{ $user->name }}
      </div>
    </div>
    {{--  --}}
    <div class="profile-index__info-line profile__info-line">
      <div class="profile-index__info-title profile__info-title">ФИО</div>
      <div class="profile-index__info-text profile__info-text">
        {{ $user->last_name }}
        {{ $user->first_name }}
        {{ $user->middle_name }}
      </div>
    </div>
    {{--  --}}
    <div class="profile-index__info-line profile__info-line">
      <div class="profile-index__info-title profile__info-title">Email:</div>
      <div class="profile-index__info-text profile__info-text">
        {{ $user->email }}
      </div>
    </div>
    {{--  --}}
    <div class="profile-index__info-line profile__info-line">
      <div class="profile-index__info-title profile__info-title">Телефон</div>
      <div class="profile-index__info-text profile__info-text">
        {{ $user->phone?->formatInternational() ?? 'Не указан' }}
      </div>
    </div>

    {{--  --}}
    @if ($user->birthday)
      <div class="profile-index__info-line profile__info-line">
        <div class="profile-index__info-title profile__info-title">
          Дата рождения
        </div>
        <div class="profile-index__info-text profile__info-text">
          {{ $user->birthday ?? 'Не указана' }}
        </div>
      </div>
    @endif

    {{--  --}}
    @if ($user->gender)
      <div class="profile-index__info-line profile__info-line">
        <div class="profile-index__info-title profile__info-title">Пол</div>
        <div class="profile-index__info-text profile__info-text">
          {{ $user->gender }}
        </div>
      </div>
    @endif

    {{--  --}}
    <a
      class="profile-index__info-button button button-mini button-alt"
      href="{{ route('profile.edit') }}"
      wire:navigate
    >
      Редактировать
    </a>
  </div>

  {{-- карта лояльности --}}
  <div class="loyalty-card__wrapper">
    <livewire:components.loyalty-card />
    <div class="loyalty-card__link">
      <a
        class="profile-index__loyalty-button button button-alt"
        href="{{ route('profile.loyalty') }}"
      >
        Подробнее
      </a>
    </div>
  </div>

  {{-- последние заказы --}}
  <div class="profile-index__orders">
    <div class="profile-index__orders-title profile__title">
      Последние заказы
    </div>
    <div class="profile-orders">
      @foreach ($orders as $order)
        <x-profile.order :$order />
      @endforeach
    </div>

    <a
      class="profile-index__orders-button button button-alt"
      href="{{ route('profile.orders.index') }}"
    >
      Ко всем заказам
    </a>
  </div>
</div>
