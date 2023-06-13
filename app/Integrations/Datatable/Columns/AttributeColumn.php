<?php

namespace App\Integrations\Datatable\Columns;

use App\Models\Attribute;
use App\Models\AttributeConfig;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AttributeColumn extends Column
{
    public bool $html = true;

    public function __construct(
        protected string $title,
        protected ?string $from,
        protected ?AttributeConfig $attributeConfig = null,
        protected ?string $locale = null
    ) {
        parent::__construct($title, $from);
    }

    public static function make(
        string $title,
        string $from = null,
        ?AttributeConfig $config = null,
        ?string $locale = null
    ): AttributeColumn {
        return new AttributeColumn($title, $from, $config, $locale);
    }

    public function getValue(Model $row): string
    {
        if ($this->attributeConfig === null) {
            return __('No Value');
        }

        $type = $this->attributeConfig->data['type'];

        if ($type == 'pim_catalog_identifier') {
            return $row['identifier'];
        }

        /** @var Product $row */
        /** @var ?Attribute $attr */
        $attr = $row->attributes()->where('code', $this->attributeConfig->code)->first();

        if ($attr === null) {
            return __('No Value');
        }

        $data = $this->getLocalizedAttribute($attr->value, $this->locale)['data'];

        if ($type == 'pim_catalog_image') {
            return view('tables.cells.image', ['url' => $this->getImageUrl($attr)]);
        }

        return is_array($data)
            ? $this->getAttributeValue($this->attributeConfig, $data)
            : $data;
    }

    protected function getLocalizedAttribute(array $attributeValues, ?string $locale = null): array
    {
        if ($locale == null) {
            $locale = auth()->user()->preferred_locale;
        }

        foreach ($attributeValues as $value) {
            if ($value['locale'] === $locale) {
                return $value;
            }
        }

        return Arr::first($attributeValues);
    }

    protected function getAttributeValue(AttributeConfig $attribute, array $data): string
    {
        $type = $attribute->data['type'] ?? null;

        return match ($type) {
            'pim_catalog_multiselect' => implode(', ', $data),
            'pim_catalog_price_collection' => $data['currency'].' '.$data['amount'],
            'pim_catalog_metric' => $data['amount'].' '.$data['unit'],
            default => json_encode($data) === false ? '' : json_encode($data),
        };
    }

    protected function getImageUrl(Attribute $attribute): string
    {
        $image = $this->getLocalizedAttribute($attribute->value);

        return route('product.image', ['code' => $image['data'], 'width' => 48, 'height' => 48]);
    }
}
