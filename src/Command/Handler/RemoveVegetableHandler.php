<?php

namespace App\Command\Handler;

use App\Command\RemoveVegetableCommand;
use App\Domain\Repository\VegetableRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class RemoveVegetableHandler
{
    public function __construct(
        private readonly VegetableRepositoryInterface $vegetableRepository,
    ) {}

    public function __invoke(RemoveVegetableCommand $command): void
    {
        $this->vegetableRepository->remove($command->id);
    }
}
