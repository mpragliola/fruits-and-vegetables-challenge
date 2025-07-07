<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;

final class Weight
{
    /** @var float Weight in grams */
    private float $unitValue;

    public function __construct(private float $value, private WeightUnits $unit)
    {
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
