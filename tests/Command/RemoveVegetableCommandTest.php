<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Command\RemoveVegetableCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RemoveVegetableCommandTest extends TestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    }

    public function testValidUuid(): void
    {
        $uuid = '123e4567-e89b-12d3-a456-426614174000';
        $command = new RemoveVegetableCommand($uuid);

        $violations = $this->validator->validate($command);

        $this->assertCount(0, $violations);
        $this->assertSame($uuid, $command->id);
    }

    public function testBlankId(): void
    {
        $command = new RemoveVegetableCommand('');

        $violations = $this->validator->validate($command);

        $this->assertGreaterThan(0, $violations->count());
        $this->assertSame('ID cannot be blank.', $violations[0]->getMessage());
    }

    public function testInvalidUuid(): void
    {
        $invalidUuid = 'not-a-uuid';
        $command = new RemoveVegetableCommand($invalidUuid);

        $violations = $this->validator->validate($command);

        $this->assertGreaterThan(0, $violations->count());
        $this->assertSame('ID must be a valid UUID.', $violations[0]->getMessage());
    }
}
