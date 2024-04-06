<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * Class UserResource
 *
 * @parent App\Http\Resources
 */
class SubscriptionResource extends JsonResource
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
            'user_full_name' => $this->user?->name,
            'renewal_at' => Carbon::parse($this->start_date)->format('Y-m-d H:i:s'),
        ];
    }
}
