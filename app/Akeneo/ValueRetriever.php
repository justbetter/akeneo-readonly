<?php

namespace App\Akeneo;

use App\Akeneo\Type\AbstractType;
use App\Akeneo\Type\MultiSelect;
use App\Akeneo\Type\Simple;
use App\Akeneo\Type\SimpleSelect;

abstract class ValueRetriever
{
    const TYPES = [
        Simple::class,
        SimpleSelect::class,
        MultiSelect::class
    ];

    public static function retrieve(
        string $attributeCode,
        string $type,
        array $data,
        ?string $scope = null,
        ?string $locale = null
    ): string|array {
        $retriever = static::getType($type);

        if ($retriever === null) {
            return '';
        }

        return $retriever->retrieve($attributeCode, $data, $scope, $locale);
    }

    protected static function getType(string $type): ?AbstractType
    {
        foreach (static::TYPES as $t) {
            $instance = app($t);

            if ($instance->matches($type)) {
                return $instance;
            }
        }

        return null;
    }
}
