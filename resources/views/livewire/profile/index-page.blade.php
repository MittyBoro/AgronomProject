<div class="profile-index">
  <div class="profile-index__greeting">
    <p>
      Здравствуйте,
      <b>{{ $user->first_name }} {{ $user->last_name }},</b>
      добро пожаловать в личный кабинет!
    </p>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button class="button button-alt button-mini">Выйти из аккаунта</button>
    </form>
  </div>

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
        {{ $user->first_name }} {{ $user->middle_name }}
      </div>
    </div>
    {{--  --}}
    <div class="profile-index__info-line profile__info-line">
      <div class="profile-index__info-title profile__info-title">E-mail:</div>
      <div class="profile-index__info-text profile__info-text">
        {{ $user->email }}
      </div>
    </div>
    {{--  --}}
    @if ($user->birthday)
      <div class="profile-index__info-line profile__info-line">
        <div class="profile-index__info-title profile__info-title">Телефон</div>
        <div class="profile-index__info-text profile__info-text">
          {{ $user->phone ?? 'Не указан' }}
        </div>
      </div>
    @endif

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
      href="/profile-edit"
    >
      Редактировать
    </a>
  </div>

  <x-profile.loyalty-card>
    <a class="profile-index__loyalty-button button button-alt" href="#">
      Подробнее
    </a>
  </x-profile.loyalty-card>

  {{-- последние заказы --}}
  <div class="profile-index__orders">
    <div class="profile-index__orders-title profile__title">
      Последние заказы
    </div>
    <div class="profile-orders">
      @foreach (range(3, 1) as $item)
        {{-- <x-profile.order :item="$item" /> --}}
      @endforeach
    </div>

    <a class="profile-index__orders-button button button-alt" href="#">
      Посмотреть все
    </a>
  </div>
</div>
