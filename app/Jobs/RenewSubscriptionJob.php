<?php

namespace App\Jobs;

use App\Mail\PaymentReceivedMail;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class RenewSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Subscription $subscription;

    /**
     * Create a new job instance.
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $newRenewalDate = Carbon::parse($this->subscription->renewal_at)->addMonth();
        $this->subscription->update(['renewal_at' => $newRenewalDate]);

       // @todo
        $to = 'admin@example.com';
        Mail::to($to)->send(new PaymentReceivedMail());
    }
}
