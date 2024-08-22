<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        $data = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
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
                Rule::unique('users')->ignore($user->id),
            ],
        ])->validatedWithBag('updateProfileInformation');

        if ($user->birthday) {
            unset($data['birthday']);
        }

        if (
            $data['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $data);
        } else {
            $user->fill($data)->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([...$input, 'email_verified_at' => null])->save();

        $user->sendEmailVerificationNotification();
    }
}
