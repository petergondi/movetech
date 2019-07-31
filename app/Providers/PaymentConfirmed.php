<?php

namespace App\Providers;

use App\Events\Samerior\MobileMoney\Mpesa\Events\C2bConfirmationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentConfirmed
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
     * @param  C2bConfirmationEvent  $event
     * @return void
     */
    public function handle(C2bConfirmationEvent $event)
    {
        //
    }
}
