<?php

namespace App\Command\Handler;

use App\Command\AddVegetableCommand;
use App\Domain\Entity\Vegetable;
use App\Domain\Repository\VegetableRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class AddVegetableHandler
{
    public function __construct(
        private readonly VegetableRepositoryInterface $vegetableRepository,
    ) {}

    public function __invoke(AddVegetableCommand $command): void
    {
        $vegetable = new Vegetable(
            name: $command->name,
            weight: $command->weight,
        );

        $this->vegetableRepository->add($vegetable);
    }
}
