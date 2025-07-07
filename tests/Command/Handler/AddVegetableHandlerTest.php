<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command\Handler;

use App\Command\AddVegetableCommand;
use App\Command\Handler\AddVegetableHandler;
use App\Domain\Entity\Vegetable;
use App\Domain\Repository\VegetableRepositoryInterface;
use App\Domain\ValueObject\Weight;
use App\Domain\ValueObject\WeightUnits;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class AddVegetableHandlerTest extends TestCase
{
    private VegetableRepositoryInterface&MockObject $vegetableRepository;
    private AddVegetableHandler $handler;

    protected function setUp(): void
    {
        $this->vegetableRepository = $this->createMock(VegetableRepositoryInterface::class);
        $this->handler = new AddVegetableHandler($this->vegetableRepository);
    }

    public function testInvokeAddsVegetableToRepository(): void
    {
        $command = new AddVegetableCommand(
            name: 'Carrot',
            weight: new Weight(
                value: 100,
                unit: WeightUnits::GRAMS,
            ),
        );

        $this->vegetableRepository
            ->expects($this->once())
            ->method('add')
            ->with($this->callback(function (Vegetable $vegetable) use ($command) {
                return $vegetable->getName() === $command->name
                    && $vegetable->getWeight() === $command->weight;
            }));

        ($this->handler)($command);
    }
}
