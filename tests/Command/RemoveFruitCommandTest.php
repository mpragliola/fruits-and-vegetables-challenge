<?php

namespace App\Tests\Command;

use App\Command\RemoveFruitCommand;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RemoveFruitCommandTest extends KernelTestCase
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
        $command = new RemoveFruitCommand('123e4567-e89b-12d3-a456-426614174000');
        $violations = $this->validator->validate($command);

        $this->assertCount(0, $violations);
    }

    public function testBlankId(): void
    {
        $command = new RemoveFruitCommand('');
        $violations = $this->validator->validate($command);

        $this->assertGreaterThan(0, count($violations));
        $this->assertSame('ID cannot be blank.', $violations[0]->getMessage());
    }

    public function testInvalidUuid(): void
    {
        $command = new RemoveFruitCommand('not-a-uuid');
        $violations = $this->validator->validate($command);

        $this->assertGreaterThan(0, count($violations));
        $this->assertSame('ID must be a valid UUID.', $violations[0]->getMessage());
    }
}
