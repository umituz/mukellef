<?php

namespace App\Services\Base;

use App\Http\Resources\SubscriptionResource;
use App\Repositories\SubscriptionRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SubscriptionService
{
    private SubscriptionRepositoryInterface $subscriptionRepository;

    public function __construct(SubscriptionRepositoryInterface $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function getSubscriptionList($userId): AnonymousResourceCollection
    {
        $items = $this->subscriptionRepository->getUserSubscriptionList($userId);

        return SubscriptionResource::collection($items);
    }

    public function createSubscription($data)
    {
        $items = $this->subscriptionRepository->createUserSubscription($data);

        return new SubscriptionResource($items);
    }
}
