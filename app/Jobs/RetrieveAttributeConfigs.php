<?php

namespace App\Jobs;

use App\Models\AttributeConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JustBetter\Akeneo\Models\Attribute;

class RetrieveAttributeConfigs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        Attribute::lazy()
            ->each(fn(Attribute $attribute) => AttributeConfig::updateOrCreate(
                ['code' => $attribute['code']],
                [
                    'code' => $attribute['code'],
                    'data' => $attribute->toArray()
                ]
            ));
    }
}
