<section class="loyalty loyalty__section">
  <div class="loyalty__container container">
    <div class="loyalty__system">
      <x-main.title>
        <span>
          Гибкая накопительная система
          <span style="display: inline-block">1 балл = 1 рубль</span>
        </span>
      </x-main.title>

      <div class="loyalty__levels">
        @foreach ($list as $item)
          <div :key="$item->id" class="loyalty__level">
            <div class="loyalty__level-title">{{ $item->title }}</div>
            <div class="loyalty__level-percent">{{ $item->percentage }}%</div>
            <div class="loyalty__level-description">
              {{ $item->description }}
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
