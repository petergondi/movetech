<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Samerior\MobileMoney\Mpesa\Events\StkPushPaymentSuccessEvent;
use Illuminate\Support\Facades\Auth;
use App\SMSSetting;

class StkPaymentReceived
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(StkPushPaymentSuccessEvent $event)
    {
        //
        $stk = $event->stk_callback; //an instance of mpesa callback model
        $mpesa_request=$event->mpesa_request;// mpesa response as array
        $logFile = "timeout.json";
        $log = fopen($logFile, "a");
        fwrite($log, $mpesa_request);
        fclose($log);
        $phonenumber=725272888;//Auth::user()->phonenumber;
        $message='Dear pETER, to Confirm your order visit www.4paykenya.co.ke .Thank You.';
        $settings=SMSSetting::all()->first();
        if(empty($settings)){
            $username = '';
            $apikey =  '';
            $senderid =  '';
        }else{

            $url="https://sms.movesms.co.ke/api/portalcompose?";
            $username = $settings->username;
            $apikey = $settings->apikey;
            $senderid = $settings->senderid;

            $postData = array(
                'username' => $username,
                'api_key' => $apikey,
                'sender' => $senderid,
                'to' => "254".(int)$phonenumber,
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
