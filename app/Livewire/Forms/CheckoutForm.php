<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;

class CheckoutForm extends Form
{
    public $full_name;

    public $email;

    public $phone;

    public $postal_code;

    public $city;

    public $address;

    public $comment;

    public $save_info = true;

    public $payment_method = '';

    public function rules()
    {
        return [
            'full_name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'phone:INTERNATIONAL,RU'],
            'postal_code' => ['nullable', 'string', 'min:6', 'max:8'],
            'city' => ['required', 'min:3', 'max:255'],
            'address' => ['required', 'min:3', 'max:255'],
            'comment' => ['nullable', 'max:5000'],
            'save_info' => ['required', 'boolean'],
            'payment_method' => [
                'required',
                Rule::in(array_keys(config('shop.drivers'))),
            ],
        ];
    }

    public function messages()
    {
        return [
            'phone' => 'Поле :attribute должно быть корректным номером.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'full_name' => 'Фамилия Имя Отчество',
            'payment_method' => 'способ оплаты',
            'comment' => 'комментарий',
        ];
    }
}
