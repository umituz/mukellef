<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserDetailResource
 *
 * @parent App\Http\Resources
 */
class UserDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'subscriptions' => SubscriptionResource::collection($this->subscriptions ?? [])->toArray(new Request()),
            'transactions' => TransactionResource::collection($this->transactions ?? [])->toArray(new Request()),
        ];
    }
}
