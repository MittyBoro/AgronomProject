<?php

namespace App\Livewire\Forms;

use App\Models\Callback;
use Livewire\Form;

class ContactForm extends Form
{
    public $name;

    public $email;

    public $phone;

    public $message;

    public function rules()
    {
        return [
            'name' => ['required', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'phone:INTERNATIONAL,RU'],
            'message' => ['required', 'min:10', 'max:10000'],
        ];
    }

    public function messages()
    {
        return [
            'phone' => 'Поле :attribute должно быть корректным номером.',
        ];
    }

    public function store(): void
    {
        $this->validate();

        $data = $this->all();

        $data['form'] = 'Написать нам (/contacts)';

        Callback::create($data);
    }
}
