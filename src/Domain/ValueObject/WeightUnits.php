<?php

namespace App\Domain\ValueObject;

enum WeightUnits 
{
    case GRAMS;
    case KILOGRAMS;
    case POUNDS;

    public function toString(bool $short = true): string
    {
        return match ($this) {
            self::GRAMS => $short ? 'g' : 'grams',
            self::KILOGRAMS => $short ? 'kg' : 'kilograms',
            self::POUNDS => $short ? 'lbs' : 'pounds',
        };
    }
}