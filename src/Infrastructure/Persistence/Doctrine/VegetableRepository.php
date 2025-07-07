<?php

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
            return $this->em->getRepository(Vegetable::class)->findAll();
        }

        $queryBuilder = $this->em->getRepository(Vegetable::class)->createQueryBuilder('f');
        !$filter->name ?? $queryBuilder->andWhere('f.name LIKE :name')
            ->setParameter('name', '%' . $filter->name . '%');
        !$filter->minWeight ?? $queryBuilder->andWhere('f.weight >= :minWeight')
            ->setParameter('minWeight', $filter->minWeight);
        !$filter->maxWeight ?? $queryBuilder->andWhere('f.weight <= :maxWeight')
            ->setParameter('maxWeight', $filter->maxWeight);

        return $queryBuilder->getQuery()->getResult();
    }
}
