<?php

namespace App\Providers;

use App\Events\Samerior\MobileMoney\Mpesa\Events\StkPushPaymentSuccessEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param  StkPushPaymentSuccessEvent  $event
     * @return void
     */
    public function handle(StkPushPaymentSuccessEvent $event)
    {
        //
    }
}
