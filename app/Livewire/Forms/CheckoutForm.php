<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CheckoutForm extends Form
{
    #[Validate('required|min:3|max:255')]
    public $full_name;

    #[Validate('required|email|max:255')]
    public $email;

    #[Validate('required|phone:INTERNATIONAL,RU')]
    public $phone;

    #[Validate('nullable|string|min:6|max:8')]
    public $postal_code;

    #[Validate('required|min:3|max:255')]
    public $city;

    #[Validate('required|min:3|max:255')]
    public $address;

    #[Validate('nullable|max:5000')]
    public $comment;

    #[Validate('boolean')]
    public $save_info = true;

    #[Validate('required|in:card,cash')]
    public $payment_method = 'card';
}
