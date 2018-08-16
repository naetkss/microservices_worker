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

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $user = new User([
            'name' => str_random(10),
            'email' => str_random(10)
        ]);
        $this->assertTrue($user->save());
        $user->balance()->create(['amount' => '10']);
        $user->save();
        $this->user = $user;
    }

    public function testDecrease()
    {
        Event::fake();

        $balance = $this->user->balance->amount;

        $amount = 50;

        $this->artisan('amount:transfer', [
            'action' => 'in',
            'user_id' => $this->user->id,
            'amount' => $amount
        ]);

        $this->artisan('queue:listen');
        $this->user->refresh();


        $this->assertEquals($balance + $amount, $this->user->balance->amount);

        Event::assertDispatched(BalanceChanged::class);

        $balance = $this->user->balance->amount;

        $amount = 20;

        $this->artisan('amount:transfer', [
            'action' => 'out',
            'user_id' => $this->user->id,
            'amount' => $amount
        ]);
        $this->artisan('queue:listen');
        $this->user->refresh();

        $this->assertEquals($balance - $amount, $this->user->balance->amount);

        Event::assertDispatched(BalanceChanged::class);
    }

}
