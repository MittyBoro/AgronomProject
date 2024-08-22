<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // 'name',
        // 'first_name',
        // 'middle_name',
        // 'last_name',
        // 'birthday',
        // 'gender',
        // 'email',
        // 'phone',
        // 'role',
        // 'password',
        $data = Validator::make($input, [
            'first_name' => ['required', 'string', 'min:2', 'max:255'],
            'middle_name' => ['nullable', 'string', 'min:2', 'max:255'],
            'last_name' => ['nullable', 'string', 'min:2', 'max:255'],
            'birthday' => ['nullable', 'string', 'date'],
            'phone' => ['nullable', 'string', 'phone:INTERNATIONAL,RU'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validated();

        if (isset($data['middle_name'])) {
            $data['name'] =
                $data['first_name'] .
                ' ' .
                mb_substr($input['middle_name'], 0, 1) .
                '.';
        } else {
            $data['name'] = $data['first_name'];
        }

        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }
}
