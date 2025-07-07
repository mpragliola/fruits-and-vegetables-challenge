<?php

namespace App\Domain\ValueObject;

enum WeightUnits: string
{
    case GRAMS = 'g';
    case KILOGRAMS = 'kg';
    case POUNDS = 'lb';
}
