<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Samerior\MobileMoney\Mpesa\Events\C2bConfirmationEvent;
use Samerior\MobileMoney\Mpesa\Events\StkPushPaymentFailedEvent;
use Samerior\MobileMoney\Mpesa\Events\StkPushPaymentSuccessEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        C2bConfirmationEvent::class => [
            PaymentConfirmed::class,
        ],
        StkPushPaymentFailedEvent::class => [
            StkPaymentFailed::class, 
        ],
        StkPushPaymentSuccessEvent::class => [
            StkPaymentReceived::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
