<?php

namespace App\Akeneo\Type;

abstract class AbstractType
{
    abstract public function retrieve(
        string $attributeCode,
        array $data,
        ?string $scope,
        ?string $locale
    ): string|array;

    public function matches(string $type): bool
    {
        return in_array($type, $this->types());
    }

    abstract public function types(): array;
}
