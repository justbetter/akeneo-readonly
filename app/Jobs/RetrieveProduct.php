<?php

namespace App\Jobs;

use App\Actions\Attribute\UpsertAttribute;
use App\Actions\Product\UpsertProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JustBetter\Akeneo\Models\Product as AkeneoProduct;

class RetrieveProduct implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $identifier,
        protected ?AkeneoProduct $akeneoProduct = null
    ) {
    }

    public function handle()
    {
        if ($this->akeneoProduct === null) {
            $this->akeneoProduct = AkeneoProduct::find($this->identifier);
        }

        $product = app(UpsertProduct::class)->upsert($this->akeneoProduct);
        app(UpsertAttribute::class)->upsert($this->akeneoProduct, $product);
    }

    public function uniqueId(): string
    {
        return $this->identifier;
    }
}
