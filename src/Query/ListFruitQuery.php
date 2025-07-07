<?php

namespace App\Query;

use App\Query\Filter\ListFruitQueryFilter;

final class ListFruitQuery
{
    public function __construct(
        public readonly ListFruitQueryFilter $filter = new ListFruitQueryFilter(),
    ) {}
}
