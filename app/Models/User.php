<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /** Gender constants. */
    const GENDER_MALE = 'male';

    const GENDER_FEMALE = 'female';

    /** Role constants. */
    const ROLE_USER = 'user';

    const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'birthday',
        'gender',
        'email',
        'phone',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'phone' => E164PhoneNumberCast::class . ':RU',
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
    }

    public function isAdmin(): Attribute
    {
        return Attribute::make(get: fn() => $this->role === self::ROLE_ADMIN);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }
}
