<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Command\AddFruitCommand;
use App\Domain\ValueObject\Weight;
use App\Domain\ValueObject\WeightUnits;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddFruitCommandTest extends TestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    }

    public function testValidCommand(): void
    {
        $weight = new Weight(150, WeightUnits::GRAMS);
        $command = new AddFruitCommand('Apple', $weight);

        $violations = $this->validator->validate($command);

        $this->assertCount(0, $violations);
        $this->assertSame('Apple', $command->name);
        $this->assertSame($weight, $command->weight);
    }

    public function testBlankName(): void
    {
        $weight = new Weight(150, WeightUnits::GRAMS);
        $command = new AddFruitCommand('', $weight);

        $violations = $this->validator->validate($command);

        $this->assertGreaterThan(0, $violations->count());
        $this->assertSame('Name cannot be blank.', $violations[0]->getMessage());
    }

    public function testNameTooLong(): void
    {
        $weight = new Weight(150, WeightUnits::GRAMS);
        $longName = str_repeat('a', 151);
        $command = new AddFruitCommand($longName, $weight);

        $violations = $this->validator->validate($command);

        $this->assertGreaterThan(0, $violations->count());
        $this->assertSame('This value is too long. It should have 150 characters or less.', $violations[0]->getMessage());
    }

    public function testZeroWeight(): void
    {
        $command = new AddFruitCommand('Banana', new Weight(0, WeightUnits::GRAMS));

        $violations = $this->validator->validate($command);

        $this->assertGreaterThan(0, $violations->count());
        $this->assertSame('Weight value must be positive.', $violations[0]->getMessage());
    }

    public function testNegativeWeight(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Weight value cannot be negative.');

        $command = new AddFruitCommand('Orange', new Weight(-50, WeightUnits::GRAMS));
    }
}
