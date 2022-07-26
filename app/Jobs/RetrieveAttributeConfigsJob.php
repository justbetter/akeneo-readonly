<?php

namespace App\Jobs;

use App\Models\AttributeConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\Akeneo\Models\Attribute;

class RetrieveAttributeConfigsJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function handle(): void
    {
        Attribute::lazy()->each(function (Attribute $attribute): void {

            /** @var AttributeConfig $config */
            $config = AttributeConfig::query()->firstOrNew(
                [
                    'code' => $attribute['code'],
                ],
                [
                    'import_filter' => [],
                ],
            );

            $config->update([
                'data' => $attribute->toArray(),
            ]);

            $config->save();
        });
    }
}
