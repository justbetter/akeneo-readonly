<?php

namespace Tests\Unit;

use App\Console\Commands\RetrieveAttributeConfigs;
use App\Console\Commands\RetrieveProduct;
use App\Console\Commands\RetrieveProducts;
use App\Console\Commands\Setup;
use App\Console\Commands\UpdateProducts;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class CommandDispatchTest extends TestCase
{
    /**
     * @dataProvider commands
     */
    public function test_commands_dispatch_jobs(string $commandClass, string $jobClass, array $params = [])
    {
        Bus::fake();

        Artisan::call($commandClass, $params);

        Bus::assertDispatched($jobClass);
    }

    public function commands(): array
    {
        return [
            [RetrieveAttributeConfigs::class, \App\Jobs\RetrieveAttributeConfigs::class],
            [RetrieveProducts::class, \App\Jobs\RetrieveProducts::class],
            [RetrieveProduct::class, \App\Jobs\RetrieveProduct::class, ['identifier' => '::identifier::']],
            [UpdateProducts::class, \App\Jobs\UpdateProducts::class],
            [Setup::class, \App\Jobs\RetrieveAttributeConfigs::class],
            [Setup::class, \App\Jobs\RetrieveProducts::class],
        ];
    }
}
