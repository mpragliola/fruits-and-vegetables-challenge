<?php

declare(strict_types=1);

namespace App\Command\Handler;

use App\Command\RemoveFruitCommand;
use App\Domain\Repository\FruitRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class RemoveFruitHandler
{
    public function __construct(
        private readonly FruitRepositoryInterface $fruitRepository,
    ) {}

    public function __invoke(RemoveFruitCommand $command): void
    {
        $this->fruitRepository->remove($command->id);
    }
}
