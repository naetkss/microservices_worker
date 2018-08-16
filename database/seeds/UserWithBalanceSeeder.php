<?php

use Illuminate\Database\Seeder;

class UserWithBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = \App\User::create([
            'id'       => 1,
            'name'     => 'user1',
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'email'    => 'user1@mail.ru',
        ]);
        $user1->balance()->create([
            'amount' => 1000
        ]);

        $user2 = \App\User::create([
            'id'   => 2,
            'name' => 'user2',
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'email' => 'user2@mail.ru'
        ]);
        $user2->balance()->create([
            'amount' => 1000
        ]);
    }
}
