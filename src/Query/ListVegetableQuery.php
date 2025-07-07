<?php

declare(strict_types=1);

namespace App\Query;

use App\Query\Filter\ListVegetableQueryFilter;

final class ListVegetableQuery
{
    public function __construct(
        public readonly ListVegetableQueryFilter $filter = new ListVegetableQueryFilter(),
    ) {}
}
