<?php

namespace App\Providers;

use App\Jobs\RenewSubscriptionJob;
use App\Models\Subscription;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class RabbitMQServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        App::bindMethod(RenewSubscriptionJob::class.'@handle', function ($job, $app) {
            return $job->handle($app->make(Subscription::class));
        });
    }
}
