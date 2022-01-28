<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Request;
use Auth;
use Log;

class RouteCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:call {uri} {--userid=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Route call from artisan uri --userid=ifnecessary';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $userid = $this->option('userid');
        if($userid){
            Auth::loginUsingId($userid, TRUE);
        }
        //Log::info("userid = ".print_r($userid,true));
        $request = Request::create($this->argument('uri'), 'GET');
        //Log::info("request = ".print_r($request,true));
        $result=app()->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request);
        //Log::info("result = ".print_r($result->content(),true));
        $responseStatus=$result->status();
        if($responseStatus==200){
            $this->info("At ".now()." uri=".$this->argument('uri').', ok');
        }else{
            $this->info("At ".now()." uri=".$this->argument('uri').', wrong');
        }

        return 0;
    }
}
