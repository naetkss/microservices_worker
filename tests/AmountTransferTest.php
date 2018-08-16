<?php

namespace tests;

use App\Events\ActionEvents\BalanceChanged;
use App\User;
use App\UsersBalance;
use Illuminate\Support\Facades\Event;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AmountTransferTest extends \TestCase
{
    //use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIncrease()
    {
        Event::fake();

        $user = new User([
            'name' => str_random(10),
            'email' => str_random(10)
            ]);
        $this->assertTrue($user->save());
        $user->balance()->create(['amount' => '10']);
        $balance = $user->balance->amount;
        $amount = 50;

        $this->artisan('amount:transfer', [
            'action' => 'in',
            'user_id' => $user->id,
            'amount' => $amount
        ]);

        $this->artisan('queue:listen');
        $user->refresh();

        $this->assertEquals($balance + $amount, $user->balance->amount);

        Event::assertDispatched(BalanceChanged::class);
    }
}
