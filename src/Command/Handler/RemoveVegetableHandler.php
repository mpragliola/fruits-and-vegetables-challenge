<?php

namespace App\Command\Handler;

use App\Command\RemoveVegetableCommand\RemoveVegetableCommand;
use App\Domain\Repository\VegetableRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class RemoveVegetableHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly VegetableRepositoryInterface $vegetableRepository,
    ) {}

    public function __invoke(RemoveVegetableCommand $command): void
    {
        $this->vegetableRepository->remove($command->id);
    }
}
