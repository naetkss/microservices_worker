<?php

namespace App\Console\Commands;

use Amqp;
use App\ActionRouter;
use App\User;
use Illuminate\Console\Command;
use Mockery\Exception;

class ListenQueue extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen for messages';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Bschmitt\Amqp\Exception\Configuration
     */
    public function handle()
    {
        $queueName = config('amqp.queue_name');

        Amqp::consume($queueName, function ($message, $resolver) {
            $task = json_decode($message->body);
            $user = User::find($task->user_id);
            $userTo = User::find($task->to_user_id);

            try {
                $route = ActionRouter::getRoute($task->action);
                $route->handle($user, $task->amount, $userTo);
                $this->info('success');
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }

            $resolver->acknowledge($message);

            if (env('APP_ENV')  === 'testing') {
                $resolver->stopWhenProcessed();
            }
        });
    }
}
