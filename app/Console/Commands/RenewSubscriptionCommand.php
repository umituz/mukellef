<?php

namespace App\Console\Commands;

use App\Jobs\RenewSubscriptionJob;
use App\Repositories\SubscriptionRepositoryInterface;

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

    public function __construct(SubscriptionRepositoryInterface $subscriptionRepository)
    {
        parent::__construct();
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptions = $this->subscriptionRepository->getRenewableItems();

        foreach ($subscriptions as $subscription) {
            RenewSubscriptionJob::dispatch($subscription);
        }

        $this->info('Renewal jobs dispatched successfully.');
    }
}
