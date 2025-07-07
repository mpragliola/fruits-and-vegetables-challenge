<?php

namespace App\Query\Handler;

use App\Domain\Repository\FruitRepositoryInterface;
use App\Query\ListFruitsQuery;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final class ListFruitsHandler
{
    public function __construct(private FruitRepositoryInterface $repo) {}

    public function __invoke(ListFruitsQuery $qry): array
    {
        return $this->repo->list($qry->filter);
    }
}
