<?php

namespace App\Command\Handler;

use App\Command\AddFruitCommand;
use App\Domain\Entity\Fruit;
use App\Domain\Repository\FruitRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

#[AsMessageHandler(bus: 'command.bus')]
final class AddFruitHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly FruitRepositoryInterface $fruitRepository,
    ) {}

    public function __invoke(AddFruitCommand $command): void
    {
        $fruit = new Fruit(
            name: $command->name,
            weight: $command->weight,
        );

        $this->fruitRepository->add($fruit);
    }
}
