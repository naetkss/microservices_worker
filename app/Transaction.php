<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    protected $guarded = ['id'];

    public function from(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function to(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
