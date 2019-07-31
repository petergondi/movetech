<?php

namespace App\Listeners;

use App\Events\Samerior\MobileMoney\Mpesa\Events\StkPushPaymentFailedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StkPaymentFailed
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
     * @param  StkPushPaymentFailedEvent  $event
     * @return void
     */
    public function handle(StkPushPaymentFailedEvent $event)
    {
        //
        $stk = $event->stk_callback; //an instance of mpesa callback model
        $mpesa_request=$event->mpesa_request;// mpesa response as array
        $logFile = "timeout.json";
        $log = fopen($logFile, "a");
        fwrite($log, $mpesa_request);
        fclose($log);
    }
}
