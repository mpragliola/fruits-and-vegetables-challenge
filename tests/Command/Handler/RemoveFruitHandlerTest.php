<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command\Handler;

use App\Command\Handler\RemoveFruitHandler;
use App\Command\RemoveFruitCommand;
use App\Domain\Repository\FruitRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class RemoveFruitHandlerTest extends TestCase
{
    private FruitRepositoryInterface&MockObject $fruitRepository;
    private RemoveFruitHandler $handler;

    protected function setUp(): void
    {
        $this->fruitRepository = $this->createMock(FruitRepositoryInterface::class);
        $this->handler = new RemoveFruitHandler($this->fruitRepository);
    }

    public function testInvokeRemovesFruit(): void
    {
        $command = new RemoveFruitCommand('some-uuid');

        $this->fruitRepository
            ->expects($this->once())
            ->method('remove')
            ->with($command->id);

        ($this->handler)($command);
    }
}
