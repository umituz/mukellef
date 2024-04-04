<?php

namespace App\Repositories;

use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

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
    public function getUserSubscriptionList()
    {
        return Auth::user()->subscriptions()->get();
    }

    /**
     * @return mixed
     */
    public function createUserSubscription($data)
    {
        return Auth::user()->subscriptions()->create($data);
    }
}
