<?php

namespace App\Providers;

use App\Listeners\ProductCreated;
use App\Listeners\ProductDeleted;
use App\Listeners\ProductUpdated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use JustBetter\AkeneoClient\Events\ProductCreatedEvent;
use JustBetter\AkeneoClient\Events\ProductRemovedEvent;
use JustBetter\AkeneoClient\Events\ProductUpdatedEvent;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ProductUpdatedEvent::class => [
            ProductUpdated::class,
        ],
        ProductCreatedEvent::class => [
            ProductCreated::class,
        ],
        ProductRemovedEvent::class => [
            ProductDeleted::class,
        ],
    ];
}
