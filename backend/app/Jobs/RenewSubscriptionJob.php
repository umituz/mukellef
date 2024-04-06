<?php

namespace App\Jobs;

use App\Enums\SubscriptionEnums;
use App\Models\Subscription;
use App\Services\Base\TransactionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class RenewSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Subscription $subscription;

    private TransactionService $transactionService;

    /**
     * Create a new job instance.
     */
    public function __construct(Subscription $subscription, TransactionService $transactionService)
    {
        $this->subscription = $subscription;
        $this->transactionService = $transactionService;

        $paymentData = [
            'user_id' => $this->subscription->user_id,
            'subscription_id' => $this->subscription->id,
            'price' => SubscriptionEnums::FIXED_PRICE,
        ];

        $this->transactionService->createTransaction($paymentData);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $newRenewalDate = Carbon::parse($this->subscription->renewal_at)->addMonth();
        $this->subscription->update(['renewal_at' => $newRenewalDate]);
    }
}
