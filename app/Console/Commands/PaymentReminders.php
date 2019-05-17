<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Reminders;
use Carbon\Carbon;
use App\SMSSetting;
class PaymentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //
        $unpaid_carts=Reminders::where('status','pending')->get();
        $settings=SMSSetting::all()->first();
        $now = Carbon::now();
        $now_format=$now->format('Y-m-d');
        foreach($unpaid_carts as $unpaid_cart){
         $date1 = new DateTime($now);
         $date2 = new DateTime($unpaid_cart->date);
         $interval = $date1->diff($date2);
         $message="Dear".$unpaid_cart->name."please make your next payment using paybill 400153 before".$unpaid_cart->date."then go to your 4-pay account and activate the payment";
         //send text reminder if the number of days remaining is 5 or less to the buyer
         if($interval<=5){
            $url="https://sms.movesms.co.ke/api/portalcompose?";

            $username = $settings->username;
            $apikey = $settings->apikey;
            $senderid = $settings->senderid;
    
            $postData = array(
                'username' => $username,
                'api_key' => $apikey,
                'sender' => $senderid,
                'to' => $unpaid_cart->phonenumber,
                'message' => $message,
                'msgtype' => 5,
                'dlr' => 0,
            );
    
    
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData
    
            ));
    
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    
            $output = curl_exec($ch);
    
            if (curl_errno($ch)) {
                // echo 'error:' . curl_error($ch);
                $output = curl_error($ch);
            }
    
            curl_close($ch);
        }
         }
        }
       
}
