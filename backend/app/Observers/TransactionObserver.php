<?php

namespace App\Observers;

use App\Models\Transaction;

class TransactionObserver extends BaseObserver
{
    /**
     * Handle The transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        $this->logger->log('New transaction created: '.$transaction->id);
    }

    /**
     * Handle The transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        $this->logger->log('Current user updated: '.$transaction->id);
    }

    /**
     * Handle The transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        $this->logger->log('The transaction soft deleted: '.$transaction->id);
    }

    /**
     * Handle The transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        $this->logger->log('The transaction restored: '.$transaction->id);
    }

    /**
     * Handle The transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        $this->logger->log('The transaction force deleted: '.$transaction->id);
    }
}
