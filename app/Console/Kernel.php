<?php

namespace App\Console;

use App\Console\Commands\RouteCall;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		RouteCall::class
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule) {
		/*$schedule->command('route:call cron/test --userid=1710')->everyMinute()->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['local'])->withoutOverlapping();*/

		$schedule->command('route:call cron/u-1 --userid=1710')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->dailyAt('13:00');

		$schedule->command('route:call cron/u-exp --userid=1710')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->dailyAt('01:00');

		$schedule->command('route:call cron/notifyForestStatus --userid=1710')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->dailyAt('07:30');

		$schedule->command('route:call cron/alertSendMsg --userid=1710')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->dailyAt('08:30');

        $schedule->command('route:call cron/alertSendMsgToContractor --userid=1710')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->dailyAt('09:30');

		$schedule->command('route:call cron/bulkUpdateOfStage --userid=1710')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->dailyAt('00:30');

		$schedule->command('route:call cron/notifyPic --userid=1710')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->everyMinute();

        $schedule->command('route:call cron/notifyBridgePic --userid=1710')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->everyTwoHours();

        $schedule->command('route:call cron/notifyWorkPic --userid=1710')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->hourly();

        $schedule->command('route:call cron/notifyRoadPic --userid=1710')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->everyTwoHours();
        
        $schedule->command('route:call cron/processPatchProgressSubmission --userid=1710')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->everyMinute();

		$schedule->command('route:call cron/timelineall --userid=1710')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->twiceDaily(6,23);

        $schedule->command('route:call cron/buildPicai --userid=1710')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->twiceDaily(10,14);

        $schedule->command('session:flush')->appendOutputTo('/var/www/html/cronlogs/mkblog.txt')->environments(['production'])->withoutOverlapping()->dailyAt('5:25');


	}

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	protected function commands() {
		$this->load(__DIR__.'/Commands');

		require base_path('routes/console.php');
	}
}

#30 2 * * * /usr/bin/php /var/www/alert/artisan schedule:run >> /tmp/cronlog
//30 7 * * * /usr/bin/curl --silent http://localhost/pwd/notifyForestStatus &>/dev/null
//30 8 * * * /usr/bin/curl --silent http://localhost/pwd/alert/sendMsg &>/dev/null

#*/1 * * * * /usr/bin/curl --silent http://localhost/pwd/tg &>/dev/null
//*/1 * * * * /usr/bin/curl --silent http://localhost/pwd/notifyPic &>/dev/null
//0 23 * * * /usr/bin/curl --silent http://localhost/pwd/timelineall &>/dev/null
//30 4 * * * /usr/bin/curl --silent http://localhost/pwd/timelineall &>/dev/null
#30 5 * * * /usr/bin/perl /home/pwd/perl/mysqlbackup.pl &>/dev/null
/* $filePath="/var/www/html/mkblog.txt";
$filePath1="/var/www/html/mkblog1.txt";
$schedule->call(function () {
echo "hi";
//DB::table('exception_logs')->delete();
$id = DB::table('exception_logs')->insertGetId(
array('type' => 1, 'message' => now())
);
Log::info("id generated = ".print_r($id,true));

})
->everyMinute()
->environments(['local', 'production'])
//->withoutOverlapping()//only for commands
->runInBackground()
//->sendOutputTo($filePath)
//->appendOutputTo($filePath1)
// ->emailOutputTo('er_manojbisht@yahoo.com')
// ->emailOutputOnFailure('er_manojbisht@yahoo.com')
;*/
