<?php

namespace App\Providers;

use App\Listeners\ProductCreated;
use App\Listeners\ProductUpdated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use JustBetter\Akeneo\Events\ProductCreated as ProductCreatedEvent;
use JustBetter\Akeneo\Events\ProductUpdated as ProductUpdatedEvent;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ProductUpdatedEvent::class => [
            ProductUpdated::class,
        ],
        ProductCreatedEvent::class => [
            ProductCreated::class,
        ],
    ];

    public function boot()
    {
        //
    }
}
