<?php



namespace App\Console;



use Illuminate\Console\Scheduling\Schedule;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
use mail;



class Kernel extends ConsoleKernel

{

    /**

     * The Artisan commands provided by your application.

     *

     * @var array

     */

    protected $commands = [

         '\App\Console\Commands\CronJob',

    ];



    /**

     * Define the application's command schedule.

     *

     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule

     * @return void

     */

    protected function schedule(Schedule $schedule)

    {

        // $schedule->command('inspire')

        //          ->hourly();

        //  $schedule->call(function () {
        //     DB::table('employee_cb_profiles')->increment('avail_leaves',1);
        // })->everyMinute();
         // $schedule->command('CronJob:cronjob')
         //         ->everyMinute();
         //          echo "Basic Email Sent. Check your inbox.";
//                  $schedule->call(function () {Mail::send('emails.test',['data'=>'nesheeth'], function($message){
//    $message->to('codingbrains21@gmail.com')->subject('tetsing mail');


//     $message->from('codingbrains21@gmail.com');
//   })})->everyMinute();
      echo "Basic Email Sent. Check your inbox.";
    
    }



    /**

     * Register the Closure based commands for the application.

     *

     * @return void

     */

    protected function commands()

    {

        require base_path('routes/console.php');

    }

}

