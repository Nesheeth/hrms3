<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Mail;
class cronjob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CronJob:cronjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'upadate value of avail leave successfully .';

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
     * @return mixed
     */
    public function handle()
    {   

       // $MailData = new \stdClass();
       //  $MailData->subject ='EOD - ';
       //  $MailData->sender_email = 'codingbrains21@gmail.com';
       //  $MailData->sender_name = 'hello';
       //  $MailData->receiver_email = 'codingbrains10@gmail.com';
       //  $MailData->receiver_name = 'ramu';
       //  $MailData->subject = ' Report ';

       //  MailController::sendMail('eod',$templateData,$MailData);
       //  // return redirect('/employee/sent-eods')->with('success',"Sent Successfully.");


        //DB::table('employee_cb_profiles')->increment('avail_leaves',1);

       Mail::send('emails.test',['data'=>'nesheeth'], function($message){
   $message->to('codingbrains10@gmail.com')->subject('tetsing mail');


    $message->from('codingbrains21@gmail.com');
  });
      echo "Basic Email Sent. Check your inbox.";
    }
}
