<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Vegetable;

interface VegetableRepositoryInterface
{
    public function add(Vegetable $f): void;
    public function remove(Vegetable $f): void;
    /** @return Vegetable[] */
    public function list(): array;
}
