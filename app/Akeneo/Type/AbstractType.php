<?php

namespace App\Akeneo\Type;

abstract class AbstractType
{
    public abstract function retrieve(
        string $attributeCode,
        array $data,
        ?string $scope,
        ?string $locale
    ): string|array;

    public function matches(string $type): bool
    {
        return in_array($type, $this->types());
    }

    public abstract function types(): array;
}
