<?php

namespace App\Repositories;

/**
 * Interface SubscriptionRepositoryInterface
 */
interface SubscriptionRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getUserSubscriptionList();

    /**
     * @return mixed
     */
    public function createUserSubscription($data);

    /**
     * @return mixed
     */
    public function getRenewableItems();
}
