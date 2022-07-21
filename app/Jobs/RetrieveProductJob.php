<?php

namespace App\Jobs;

use App\Actions\Product\UpsertProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\Akeneo\Models\Product;

class RetrieveProductJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        public string $identifier,
        public ?Product $product = null
    ) {
    }

    public function handle(UpsertProduct $upsertProduct): void
    {
        if ($this->product === null) {
            $this->product = Product::find($this->identifier);
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
