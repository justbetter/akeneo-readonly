<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JustBetter\Akeneo\Models\Product as AkeneoProduct;

class UpdateProduct implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected string $identifier)
    {
    }

    public function handle()
    {
        $akeneoProduct = AkeneoProduct::find($this->identifier);

        if ($akeneoProduct === null) {
            $this->deleteProduct();
            return;
        }

        RetrieveProduct::dispatch($this->identifier, $akeneoProduct);
    }

    protected function deleteProduct()
    {
        optional(Product::where('identifier', $this->identifier)->first())->delete();
    }

    public function uniqueId(): string
    {
        return $this->identifier;
    }

    public function tags(): array
    {
        return [$this->identifier];
    }
}
