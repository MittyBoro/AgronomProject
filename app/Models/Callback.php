<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class Callback extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'user_hash',
        'is_archived',
        'form',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            $model->user_hash = md5(
                serialize([
                    request()->ip(),
                    request()->server('HTTP_USER_AGENT'),
                ]),
            );

            $canCreate = !self::where('user_hash', $model->user_hash)
                ->where('created_at', '>=', Carbon::now()->subMinutes(1))
                ->exists();

            if (!$canCreate) {
                throw new Exception(
                    'Слишком частые обращения, пожалуйста, повторите позднее',
                );
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
            'is_archived' => 'boolean',
            'phone' => E164PhoneNumberCast::class . ':RU',
        ];
    }
}
