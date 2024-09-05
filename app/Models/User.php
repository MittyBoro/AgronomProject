<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

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
        'loyalty_id',
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
            'gender' => GenderEnum::class,
            'role' => RoleEnum::class,
        ];
    }

    protected static function booted(): void
    {
        static::created(function ($user): void {
            $loyalty = Loyalty::orderBy('percent', 'asc')->first();
            if ($loyalty) {
                $user->loyalty()->associate($loyalty);
            }
        });
    }

    /**
     * Get the reviews for the user.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function loyalty()
    {
        return $this->belongsTo(Loyalty::class);
    }

    public function bonuses()
    {
        return $this->hasMany(Bonus::class);
    }

    protected function isAdmin(): Attribute
    {
        return Attribute::make(get: fn() => $this->role === RoleEnum::Admin);
    }

    protected function balance(): Attribute
    {
        return Attribute::make(
            get: fn() => (int) $this->bonuses->sum('amount') ?? 0,
        )->shouldCache();
    }

    /**
     * Get the panel permissions for the user.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    /**
     * Get the globally searchable attributes for the panel.
     */
    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'first_name',
            'middle_name',
            'last_name',
            'birthday',
            'gender',
            'email',
            'phone',
        ];
    }

    /**
     * Установить уровень пользователя.
     */
    public function setLoyalty(): void
    {
        $sumOfOrders = (int) $this->orders()->isCompleted()->sum('total_price');

        $loyalty = Loyalty::query()
            ->where('min_order_sum', '<=', $sumOfOrders)
            ->orderByDesc('min_order_sum')
            ->first();

        $this->loyalty()->associate($loyalty);
        $this->save();
    }
}
