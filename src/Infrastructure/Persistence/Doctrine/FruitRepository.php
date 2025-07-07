<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\Fruit;
use App\Domain\Repository\FruitRepositoryInterface;
use App\Query\Filter\ListFruitQueryFilter;
use Doctrine\ORM\EntityManagerInterface;

// @TODO: There is a lot of duplication between anything related to fruits and 
// veggies. I used here and there common interfaces and base classes, but this happens also because
// the take home test uses a simple data model.
// In real scenarios this would be a coupling and it has to be evaluated depending
// on the context. So I won't implement base classes everywhere
final class FruitRepository implements FruitRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $em) {}

    public function add(Fruit $f): void
    {
        $this->em->persist($f);
        $this->em->flush();
    }

    public function remove(string $id): void
    {
        $f = $this->em->getReference(Fruit::class, $id);
        $this->em->remove($f);
        $this->em->flush();
    }

    /** @return Fruit[] */
    public function list(ListFruitQueryFilter $filter): array
    {
        if ($filter->isEmpty()) {
            $fruits = $this->em->getRepository(Fruit::class)->findAll();

            return $fruits ?: [];
        }

        $queryBuilder = $this->em->getRepository(Fruit::class)->createQueryBuilder('f');
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
