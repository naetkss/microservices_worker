<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class UsersBalance extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
    ];

    /**
     * Increases user balance on amount
     *
     * @param float $amount
     */
    public function increase(float $amount): void
    {
        if (0 >= $amount) {
            throw new Exception('incorrect amount');
        }

        DB::transaction(
            function () use ($amount) {
                $this->increment('amount', $amount);
            }
        );
    }

    /**
     * Decreases user balance on amount
     *
     * @param float $amount
     */
    public function decrease(float $amount): void
    {
        if (0 >= $amount) {
            throw new Exception('incorrect amount');
        }
        if ($amount > $this->amount) {
            throw new Exception('insufficient balance');
        }
        DB::transaction(
            function () use ($amount) {
                $this->decrement('amount', $amount);
            }
        );
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
