<?php

namespace App\Actions\Product;

use Akeneo\Pim\ApiClient\Search\SearchBuilder;
use App\Jobs\RetrieveProductJob;
use App\Models\AttributeConfig;
use JustBetter\Akeneo\Integrations\Akeneo;
use JustBetter\Akeneo\Models\Product as AkeneoProduct;

class RetrieveProducts
{
    protected const PAGE_SIZE = 50;

    public function __construct(protected Akeneo $akeneo)
    {
    }

    public function handle(): void
    {
        $productApi = $this->akeneo->getProductApi();

        $products = $productApi->all(static::PAGE_SIZE, ['search' => $this->getFilters()]);

        foreach ($products as $product) {
            $akeneoProduct = new AkeneoProduct($product);
            RetrieveProductJob::dispatch($akeneoProduct['identifier'], $akeneoProduct);
        }
    }

    protected function getFilters(): array
    {
        $searchBuilder = new SearchBuilder();

        AttributeConfig::query()
            ->where('import_filter', 'LIKE', '%enabled": true%')
            ->get()
            ->each(function (AttributeConfig $config) use (&$searchBuilder) {

                $scopable = $config['data']['scopable'] && ! blank($config->import_filter['scope'] ?? null);
                $localizable = $config['data']['localizable'] && ! blank($config->import_filter['locale'] ?? null);

                $options = [];

                if ($scopable) {
                    $options['scope'] = $config->import_filter['scope'];
                }

                if ($localizable) {
                    $options['locale'] = $config->import_filter['locale'];
                }

                $value = $config->import_filter['value'];

                if (str_contains($config->import_filter['operator'], 'IN')) {
                    $value = explode(',', $value);
                }

                $searchBuilder->addFilter(
                    $config->code,
                    $config->import_filter['operator'],
                    $value,
                    $options
                );

            });

        return $searchBuilder->getFilters();
    }

}
