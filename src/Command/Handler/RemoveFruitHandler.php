<?php

namespace App\Command\Handler;

use App\Command\RemoveFruitCommand;
use App\Domain\Entity\Fruit;

use App\Domain\Repository\FruitRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class RemoveFruitHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly FruitRepositoryInterface $fruitRepository,
    ) {}

    public function __invoke(RemoveFruitCommand $command): void
    {
        $this->fruitRepository->remove($command->id);
    }
}
