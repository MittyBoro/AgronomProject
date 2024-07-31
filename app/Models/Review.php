<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'is_approved',
        'rating',
        'name',
        'comment',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_approved' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Review $record): void {
            if ( ! $record->name) {
                $record->name = 'Аноним';
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
