<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * 任务运行的超时时间。
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * 任务最大尝试次数。
     *
     * @var int
     */
    public $tries = 5;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user =$user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

    }


    //
    // public function failed(Exception $exception)
    // {
    //     // 给用户发送失败通知，等等...
    // }
}
