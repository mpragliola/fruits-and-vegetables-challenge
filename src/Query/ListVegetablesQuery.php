<?php

namespace App\Query;

use App\Query\Filter\ListVegetablesQueryFilter;

final class ListVegetablesQuery
{
    public function __construct(
        public readonly ListVegetablesQueryFilter $filter = new ListVegetablesQueryFilter(),
    ) {}
}
