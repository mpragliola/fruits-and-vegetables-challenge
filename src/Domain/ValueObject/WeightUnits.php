<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

enum WeightUnits: string
{
    case GRAMS = 'g';
    case KILOGRAMS = 'kg';
    case POUNDS = 'lb';
}
