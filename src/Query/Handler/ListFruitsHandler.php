<?php

namespace App\Query\Handler;

use App\Domain\Repository\FruitRepositoryInterface;
use App\Query\ListFruitsQuery;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ListFruitsHandler implements MessageHandlerInterface
{
    public function __construct(private FruitRepositoryInterface $repo) {}

    public function __invoke(ListFruitsQuery $qry): array
    {
        return $this->repo->list($qry->filter);
    }
}
