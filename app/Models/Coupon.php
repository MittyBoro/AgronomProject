<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'percent',
        'count',
        'is_active',
        'expires_at',
    ];

    protected static function booted(): void
    {
        static::saving(function (Coupon $coupon): void {
            $coupon->code = Str::upper($coupon->code);
            if ($coupon->count < 1) {
                $coupon->is_active = false;
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'percent' => 'float',
            'count' => 'integer',
            'is_active' => 'boolean',
            'expires_at' => 'datetime',
        ];
    }

    public function scopeIsActive($query)
    {
        return $query
            ->where('is_active', 1)
            ->where('count', '>', 0)
            ->where(
                fn($q) => $q
                    ->where('expires_at', '>', now())
                    ->orWhereNull('expires_at'),
            );
    }
}
