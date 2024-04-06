<?php

namespace App\Observers;

use App\Models\Subscription;

class SubscriptionObserver extends BaseObserver
{
    /**
     * Handle The subscription "created" event.
     */
    public function created(Subscription $subscription): void
    {
        $this->logger->log('New subscription created: '.$subscription->name);
    }

    /**
     * Handle The subscription "updated" event.
     */
    public function updated(Subscription $subscription): void
    {
        $this->logger->log('Current user updated: '.$subscription->name);
    }

    /**
     * Handle The subscription "deleted" event.
     */
    public function deleted(Subscription $subscription): void
    {
        $this->logger->log('The subscription soft deleted: '.$subscription->name);
    }

    /**
     * Handle The subscription "restored" event.
     */
    public function restored(Subscription $subscription): void
    {
        $this->logger->log('The subscription restored: '.$subscription->name);
    }

    /**
     * Handle The subscription "force deleted" event.
     */
    public function forceDeleted(Subscription $subscription): void
    {
        $this->logger->log('The subscription force deleted: '.$subscription->name);
    }
}
