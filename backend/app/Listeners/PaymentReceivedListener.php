<?php

namespace App\Listeners;

use App\Events\PaymentReceivedEvent;
use App\Mail\PaymentReceivedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class PaymentReceivedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentReceivedEvent $event): void
    {
        Mail::to($event->data->email)->send(new PaymentReceivedMail($event->data));
    }
}
