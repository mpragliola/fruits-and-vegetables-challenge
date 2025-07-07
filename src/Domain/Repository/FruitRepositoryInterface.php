<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Fruit;
use App\Query\Filter\ListFruitsQueryFilter;

interface FruitRepositoryInterface
{
    public function add(Fruit $f): void;
    public function remove(Fruit $f): void;
    /** @return Fruit[] */
    public function list(ListFruitsQueryFilter $filter): array;
}
