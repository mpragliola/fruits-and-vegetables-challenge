<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command\Handler;

use App\Command\AddFruitCommand;
use App\Command\Handler\AddFruitHandler;
use App\Domain\Entity\Fruit;
use App\Domain\Repository\FruitRepositoryInterface;
use App\Domain\ValueObject\Weight;
use App\Domain\ValueObject\WeightUnits;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class AddFruitHandlerTest extends TestCase
{
    private FruitRepositoryInterface&MockObject $fruitRepository;
    private AddFruitHandler $handler;

    protected function setUp(): void
    {
        $this->fruitRepository = $this->createMock(FruitRepositoryInterface::class);
        $this->handler = new AddFruitHandler($this->fruitRepository);
    }

    public function testInvokeAddsFruitToRepository(): void
    {
        $command = new AddFruitCommand(
            name: 'Apple',
            weight: new Weight(
                value: 150,
                unit: WeightUnits::GRAMS,
            ),
        );

        $this->fruitRepository
            ->expects($this->once())
            ->method('add')
            ->with($this->callback(function (Fruit $fruit) use ($command) {
                return $fruit->getName() === $command->name
                    && $fruit->getWeight() === $command->weight;
            }));

        ($this->handler)($command);
    }
}
