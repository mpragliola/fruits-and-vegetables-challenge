<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Fruit;
use App\Query\Filter\ListFruitQueryFilter;

interface FruitRepositoryInterface
{
    public function add(Fruit $f): void;
    public function remove(string $id): void;
    /** @return Fruit[] */
    public function list(ListFruitQueryFilter $filter): array;
}
