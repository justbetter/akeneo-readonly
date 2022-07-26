<?php

namespace App\Jobs;

use App\Actions\Product\RetrieveProducts;
use App\Actions\Product\TruncateProducts;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class RetrieveProductsJob implements ShouldQueue //, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function handle(
        TruncateProducts $truncateProducts,
        RetrieveProducts $retrieveProducts
    ): void {
        $truncateProducts->handle();
        $retrieveProducts->handle();
    }
}
