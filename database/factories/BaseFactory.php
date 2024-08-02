<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

abstract class BaseFactory extends Factory
{
    protected function loadMedia(): bool
    {
        return config('app.faker_has_media', false);
    }
}
