<?php

namespace App\Repositories;

/**
 * Interface SubscriptionRepositoryInterface
 */
interface SubscriptionRepositoryInterface
{
    /**
     * @param $userId
     * @return mixed
     */
    public function getUserSubscriptionList($userId);

    /**
     * @return mixed
     */
    public function createUserSubscription($data);

    /**
     * @return mixed
     */
    public function getRenewableItems();
}
