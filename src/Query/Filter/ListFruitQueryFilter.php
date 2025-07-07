<?php

declare(strict_types=1);

namespace App\Query\Filter;

final class ListFruitQueryFilter
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?float $minWeight = null,
        public readonly ?float $maxWeight = null,
    ) {}

    public function isEmpty(): bool
    {
        return is_null($this->name) && is_null($this->minWeight) && is_null($this->maxWeight);
    }
}
