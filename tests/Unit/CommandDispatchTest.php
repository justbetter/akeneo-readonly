<?php

namespace Tests\Unit;

use App\Console\Commands\RetrieveAttributeConfigsCommand;
use App\Console\Commands\RetrieveProductCommand;
use App\Console\Commands\RetrieveProductsCommand;
use App\Console\Commands\SetupCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class CommandDispatchTest extends TestCase
{
    /**
     * @dataProvider commands
     */
    public function test_commands_dispatch_jobs(string $commandClass, string $jobClass, array $params = []): void
    {
        Bus::fake();

        Artisan::call($commandClass, $params);

        Bus::assertDispatched($jobClass);
    }

    public static function commands(): array
    {
        return [
            [RetrieveAttributeConfigsCommand::class, \App\Jobs\RetrieveAttributeConfigsJob::class],
            [RetrieveProductsCommand::class, \App\Jobs\RetrieveProductsJob::class],
            [RetrieveProductCommand::class, \App\Jobs\RetrieveProductJob::class, ['identifier' => '::identifier::']],
            [SetupCommand::class, \App\Jobs\RetrieveAttributeConfigsJob::class],
            [SetupCommand::class, \App\Jobs\RetrieveProductsJob::class],
        ];
    }
}
