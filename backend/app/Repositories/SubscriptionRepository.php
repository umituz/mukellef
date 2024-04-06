<?php

namespace App\Repositories;

use App\Models\Subscription;

/**
 * Class SubscriptionRepository
 */
class SubscriptionRepository extends BaseRepository implements SubscriptionRepositoryInterface
{
    private Subscription $subscription;

    public function __construct(Subscription $subscription)
    {
        parent::__construct($subscription);

        $this->subscription = $subscription;
    }

    /**
     * @return mixed
     */
    public function getUserSubscriptionList($userId)
    {
        return $this->subscription->where('user_id', $userId)->get();
    }

    /**
     * @return mixed
     */
    public function createUserSubscription($data)
    {
        return $this->subscription->create($data);
    }

    /**
     * @return mixed
     */
    public function getRenewableItems()
    {
        return $this->subscription->where('renewal_at', '<=', now())->get();
    }
}
