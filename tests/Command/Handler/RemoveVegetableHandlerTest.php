<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command\Handler;

use App\Command\Handler\RemoveVegetableHandler;
use App\Command\RemoveVegetableCommand;
use App\Domain\Repository\VegetableRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class RemoveVegetableHandlerTest extends TestCase
{
    private VegetableRepositoryInterface&MockObject $vegetableRepository;
    private RemoveVegetableHandler $handler;

    protected function setUp(): void
    {
        $this->vegetableRepository = $this->createMock(VegetableRepositoryInterface::class);
        $this->handler = new RemoveVegetableHandler($this->vegetableRepository);
    }

    public function testInvokeRemovesVegetable(): void
    {
        $command = new RemoveVegetableCommand(id: 'some-uuid');

        $this->vegetableRepository
            ->expects($this->once())
            ->method('remove')
            ->with($command->id);

        ($this->handler)($command);
    }
}
