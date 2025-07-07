<?php

declare(strict_types=1);

namespace App\Query\Handler;

use App\Domain\Repository\VegetableRepositoryInterface;
use App\Query\ListVegetableQuery;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final class ListVegetableHandler
{
    public function __construct(
        private VegetableRepositoryInterface $vegetableRepository,
    ) {}

    public function __invoke(ListVegetableQuery $query): array
    {
        $filter = $query->filter;

        return $this->vegetableRepository->list($filter);
    }
}
