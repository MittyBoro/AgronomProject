<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loyalty extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'description', 'percent', 'min_order_sum'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'min_order_sum' => 'float',
            'percent' => 'float',
        ];
    }

    public function nextLevel(): ?self
    {
        return $this->where('min_order_sum', '>', $this->min_order_sum)
            ->orderBy('min_order_sum')
            ->first();
    }
}
