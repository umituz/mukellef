<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Subscription\SubscriptionRequest;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Base\SubscriptionService;

class SubscriptionsController extends BaseController
{
    private SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $items = $this->subscriptionService->getSubscriptionList($user->id);

        return $this->ok($items, __('Subscription List'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriptionRequest $request, User $user)
    {
        $item = $this->subscriptionService->createSubscription([
            'user_id' => $user->id,
            'name' => $request->name,
            'renewal_at' => $request->renewal_at,
        ]);

        return $this->created($item, __('Created successfully!'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriptionRequest $request, User $user, Subscription $subscription)
    {
        $subscription->update([
            'user_id' => $user->id,
            'name' => $request->name,
            'renewal_at' => $request->renewal_at,
        ]);

        return $this->ok($subscription, __('Updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Subscription $subscription)
    {
        $subscription->delete();

        return $this->noContent([], __('Subscription deleted successfully'), 401);
    }
}
