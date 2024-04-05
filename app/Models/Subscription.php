<?php

namespace App\Models;

use App\Models\Scopes\SortingScope;
use App\Observers\SubscriptionObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends BaseModel
{
    protected $fillable = [
        'user_id',
        'name',
        'renewal_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::observe(SubscriptionObserver::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
