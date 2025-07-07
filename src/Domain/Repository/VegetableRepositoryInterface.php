<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Vegetable;
use App\Query\Filter\ListVegetableQueryFilter;

interface VegetableRepositoryInterface
{
    public function add(Vegetable $f): void;
    public function remove(string $id): void;
    /** @return Vegetable[] */
    public function list(ListVegetableQueryFilter $f): array;
}
