<form
  wire:submit.prevent="store"
  style="margin-bottom: 50px"
  class="contacts__form contacts__form-review"
  x-data="{ isOpened: false }"
>
  <div class="head-row__title">
    <div class="contacts__form-title">
      Вы приобрели этот товар, поделитесь своим мнением 📝
    </div>
    <div
      class="contacts__form-submit button"
      :class="{ 'button-alt': isOpened }"
      x-on:click="isOpened = !isOpened"
    >
      <span x-show="!isOpened">Оставить отзыв</span>
      <span x-cloak x-show="isOpened">Скрыть</span>
    </div>
  </div>
  <div x-cloak class="review__form" x-show="isOpened">
    <div class="contacts__form-messages">
      <x-form.validation-errors />
      <x-form.session-status />
    </div>

    @if (! session()->has('status'))
      {{--  --}}
      <x-form.input
        class="contacts__form"
        id="name"
        label="Отображаемое имя"
        wire:model="name"
        required
      />

      {{--  --}}
      <div class="contacts__form-group field-group">
        <div class="contacts__form-label field-label required">Оценка</div>
        <div class="contacts__form-rating field-rating">
          <input
            class="field-rating-input"
            type="radio"
            name="rating"
            value="5"
            wire:model="rating"
            required
          />
          <input
            class="field-rating-input"
            type="radio"
            name="rating"
            value="4"
            wire:model="rating"
            required
          />
          <input
            class="field-rating-input"
            type="radio"
            name="rating"
            value="3"
            wire:model="rating"
            required
          />
          <input
            class="field-rating-input"
            type="radio"
            name="rating"
            value="2"
            wire:model="rating"
            required
          />
          <input
            class="field-rating-input"
            type="radio"
            name="rating"
            value="1"
            wire:model="rating"
            required
          />
        </div>
      </div>
      {{--  --}}
      <x-form.textarea
        class="grid-col-full contacts__form"
        id="message"
        label="Отзыв"
        rows="5"
        wire:model="comment"
        required
      />
      <div class="contacts__form-submit-row">
        <button class="contacts__form-submit button" type="submit">
          Отправить
        </button>
      </div>
    @endif
  </div>
</form>
