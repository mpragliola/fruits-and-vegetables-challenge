<?php

namespace App\Query;

use App\Query\Filter\ListFruitsQueryFilter;
use App\Query\Filter\ListItemsQueryFilter;

final class ListFruitsQuery
{
    public function __construct(
        public readonly ListFruitsQueryFilter $filter = new ListFruitsQueryFilter(),
    ) {}
}
