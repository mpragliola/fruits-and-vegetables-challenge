<?php

namespace App\Query\Filter;

final class ListVegetablesQueryFilter
{
    public function __construct(
        public readonly ?string $filter = null,
        public readonly ?float $minWeight = null,
        public readonly ?float $maxWeight = null,
    ) {}

    public function isEmpty(): bool
    {
        return is_null($this->filter) && is_null($this->minWeight) && is_null($this->maxWeight);
    }
}
