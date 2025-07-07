<?php

declare(strict_types=1);

namespace App\Command\Handler;

use App\Command\AddFruitCommand;
use App\Command\AddVegetableCommand;
use App\Command\ParseItemCollectionCommand;
use App\Domain\Entity\AbstractItem;
use App\Domain\Entity\Fruit;
use App\Domain\Entity\Vegetable;
use App\Service\ItemCollectionParser;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler(bus: 'command.bus')]
final class ParseItemCollectionHandler
{
    public function __construct(
        private readonly ItemCollectionParser $itemCollectionParser,
        private readonly MessageBusInterface $bus,
    ) {}

    public function __invoke(ParseItemCollectionCommand $command): void
    {
        $parsed = $this->itemCollectionParser->parse($command->jsonBlob);

        foreach ($parsed as $item) {
            if (!$item instanceof AbstractItem) {
                throw new \InvalidArgumentException('Parsed item is not an instance of AbstractItem.');
            }

            if ($item instanceof Fruit) {
                $this->bus->dispatch(
                    new AddFruitCommand(
                        name: $item->getName(),
                        weight: $item->getWeight()
                    )
                );
            }

            if ($item instanceof Vegetable) {
                $this->bus->dispatch(
                    new AddVegetableCommand(
                        name: $item->getName(),
                        weight: $item->getWeight()
                    )
                );
            }
        }
    }
}
