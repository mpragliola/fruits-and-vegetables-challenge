<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\Vegetable;
use App\Domain\Repository\VegetableRepositoryInterface;
use App\Query\Filter\ListVegetableQueryFilter;
use Doctrine\ORM\EntityManagerInterface;

final class VegetableRepository implements VegetableRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $em) {}

    public function add(Vegetable $f): void
    {
        $this->em->persist($f);
        $this->em->flush();
    }

    public function remove(string $id): void
    {
        $f = $this->em->getReference(Vegetable::class, $id);
        $this->em->remove($f);
        $this->em->flush();
    }

    /** @return Vegetable[] */
    public function list(ListVegetableQueryFilter $filter): array
    {
        if ($filter->isEmpty()) {
            $vegetables = $this->em->getRepository(Vegetable::class)->findAll();

            return $vegetables ?: [];
        }

        $queryBuilder = $this->em->getRepository(Vegetable::class)->createQueryBuilder('f');
        if ($filter->name) {
            $queryBuilder->andWhere('f.name LIKE :name')
                ->setParameter('name', '%' . $filter->name . '%');
        }
        if ($filter->minWeight) {
            $queryBuilder->andWhere('f.weight.unitValue >= :minWeight')
                ->setParameter('minWeight', $filter->minWeight);
        }
        if ($filter->maxWeight) {
            $queryBuilder->andWhere('f.weight.unitValue <= :maxWeight')
                ->setParameter('maxWeight', $filter->maxWeight);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
