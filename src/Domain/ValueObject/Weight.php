<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
final class Weight
{
    /** @var float Weight in grams */
    #[ORM\Column(type: 'float')]
    private float $unitValue;

    // @TODO: we could try use first-class enum support, but for now we play safe
    public function __construct(
        #[Assert\Positive(message: 'Weight value must be positive.')]
        private float $value,
        #[ORM\Column(type: 'string', length: 10, enumType: WeightUnits::class)]
        private WeightUnits $unit,
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException('Weight value cannot be negative.');
        }

        $this->unitValue = $this->convertToGrams($value, $unit);
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getUnitValue(): float
    {
        return $this->unitValue;
    }

    public function toString(): string
    {
        return sprintf('%.2f %s', $this->value, $this->unit->toString());
    }

    // TODO: this could be a Service class
    private function convertToGrams(float $value, WeightUnits $unit): float
    {
        return match ($unit) {
            WeightUnits::GRAMS => $value,
            WeightUnits::KILOGRAMS => $value * 1000,
            WeightUnits::POUNDS => $value * 453.59237,
        };
    }
}
