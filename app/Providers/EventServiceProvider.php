<?php

namespace App\Providers;

use App\Listeners\ProductCreated;
use App\Listeners\ProductUpdated as ProductUpdatedEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use JustBetter\Akeneo\Events\ProductCreated as ProductCreatedEvent;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ProductUpdatedEvent::class => [
            ProductUpdatedEvent::class
        ],
        ProductCreatedEvent::class => [
            ProductCreated::class
        ]
    ];

    public function boot()
    {
        //
    }
}
