<?php

namespace App\Jobs;

use App\Actions\Product\UpsertProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\AkeneoClient\Client\Akeneo;

class RetrieveProductJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        public string $identifier,
        public ?array $product = null
    ) {
    }

    public function handle(UpsertProduct $upsertProduct, Akeneo $akeneo): void
    {
        if ($this->product === null) {
            $this->product = $akeneo->getProductApi()->get($this->identifier);
        }

        $upsertProduct->upsert($this->product);
    }

    public function uniqueId(): string
    {
        return $this->identifier;
    }

    public function tags(): array
    {
        return [
            $this->identifier,
        ];
    }
}
