<?php

namespace App\Console\Commands;

use App\Jobs\RenewSubscriptionJob;
use App\Repositories\SubscriptionRepositoryInterface;
use App\Services\Base\TransactionService;

class RenewSubscriptionCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:renew-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renew subscriptions that are due for renewal';

    private SubscriptionRepositoryInterface $subscriptionRepository;

    private TransactionService $transactionService;

    public function __construct(SubscriptionRepositoryInterface $subscriptionRepository, TransactionService $transactionService)
    {
        parent::__construct();

        $this->subscriptionRepository = $subscriptionRepository;
        $this->transactionService = $transactionService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptions = $this->subscriptionRepository->getRenewableItems();

        foreach ($subscriptions as $subscription) {
            RenewSubscriptionJob::dispatch($subscription, $this->transactionService);
        }

        $this->info('Renewal jobs dispatched successfully.');
    }
}
