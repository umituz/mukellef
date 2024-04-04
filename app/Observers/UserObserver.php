<?php

namespace App\Observers;

use App\Models\User;

class UserObserver extends BaseObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->logger->log('New user created: ' . $user->name);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $this->logger->log('Current user updated: ' . $user->name);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $this->logger->log('The user soft deleted: ' . $user->name);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        $this->logger->log('The user restored: ' . $user->name);
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        $this->logger->log('The user force deleted: ' . $user->name);
    }
}
