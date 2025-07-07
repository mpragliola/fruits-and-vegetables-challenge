<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
final class Weight implements JsonSerializable
{
    /** @var float Weight in grams */
    #[Assert\Positive(message: 'Weight value must be positive.')]
    #[ORM\Column(type: 'float')]
    public readonly float $unitValue;

    #[ORM\Column(type: 'string', length: 10, enumType: WeightUnits::class)]
    public readonly WeightUnits $unit;

    // @TODO: we could try use first-class enum support, but for now we play safe
    public function __construct(float $value, WeightUnits $unit)
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Weight value cannot be negative.');
        }

        $this->unit = $unit;
        $this->unitValue = $this->convertToGrams($value, $unit);
    }

    public function jsonSerialize(): array
    {
        return [
            'unit' => $this->unit->value,
            'unitValue' => $this->unitValue,
        ];
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
