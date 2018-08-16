<?php

namespace App\Console\Commands;

use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Console\Command;

class TransferAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amount:transfer {user_id} {action} {amount} {to_user_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfers amount';

    /**
     * TransferAmount constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $task = [
            'action'     => $this->argument('action'),
            'user_id'    => $this->argument('user_id'),
            'amount'     => $this->argument('amount'),
            'to_user_id' => $this->argument('to_user_id'),
        ];

        $queueName = config('amqp.queue_name');

        $task = json_encode($task);
        Amqp::publish($queueName, $task, [
            'queue' => $queueName,
        ]);
    }
}
