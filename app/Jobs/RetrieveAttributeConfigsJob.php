<?php

namespace App\Jobs;

use App\Models\AttributeConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\AkeneoClient\Client\Akeneo;

class RetrieveAttributeConfigsJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function handle(Akeneo $akeneo): void
    {
        /** @var array $attribute */
        foreach ($akeneo->getAttributeApi()->all() as $attribute) {
            /** @var AttributeConfig $config */
            $config = AttributeConfig::query()->firstOrNew(
                [
                    'code' => $attribute['code'],
                ],
                [
                    'import_filter' => [],
                ],
            );

            $config->data = $attribute;

            $config->save();
        }
    }
}
