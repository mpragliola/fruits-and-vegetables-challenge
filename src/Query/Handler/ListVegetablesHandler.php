<?php

namespace App\Query\Handler;

use App\Domain\Repository\VegetableRepositoryInterface;
use App\Query\ListVegetablesQuery;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final class ListVegetablesHandler
{
    public function __construct(
        private VegetableRepositoryInterface $vegetableRepository,
    ) {}

    /**
     * @param ListVegetablesQuery $query
     * @return array
     */
    public function __invoke(ListVegetablesQuery $query): array
    {
        $filter = $query->filter;

        return $this->vegetableRepository->list($filter);
    }
}
