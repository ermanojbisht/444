<?php

namespace App\Jobs\Acr;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailAlertJob implements ShouldQueue
{
    /**
     * @var mixed
     */
    public $employee_id;
    /**
     * @var mixed
     */
    public $userPendingAcrs;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($employee_id, $userPendingAcrs)
    {
        //
        $this->employee_id = $employee_id;
        $this->userPendingAcrs = $userPendingAcrs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Log::info("employee_id = ".print_r($this->employee_id, true));
        $user = User::whereEmployeeId($this->employee_id)->first();
        //Log::info("user = ".print_r($user, true));
        $user->acrAlertNotification($this->userPendingAcrs);
    }
}
