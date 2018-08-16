<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Mockery\Exception;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * User constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function balance(): HasOne
    {
        return $this->hasOne(UsersBalance::class);
    }

    public function getBalance(): ?float
    {
        return $this->balance->amount ?? null;
    }

    /**
     * Send amount from current User to recipient
     *
     * @param User $recipient
     * @param float $amount
     *
     * @return void
     */
    public function sendTo(User $recipient, float $amount): void
    {
        if ($amount < 0) {
            throw new Exception('incorrect amount');
        }

        if ($amount > $this->getBalance()) {
            throw new Exception('insufficient balance');
        }

        DB::transaction(
            function () use ($recipient, $amount) {
                $transaction = new Transaction([
                    'amount'       => $amount,
                    'from_user_id' => $this->id,
                    'to_user_id'   => $recipient->id,
                ]);
                $transaction->save();
                $this->balance->decrease($amount);
                $recipient->balance->increase($amount);
            }
        );
    }
}
