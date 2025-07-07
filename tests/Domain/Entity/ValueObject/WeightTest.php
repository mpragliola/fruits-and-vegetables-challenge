<?php

namespace App\Tests\Domain\Entity\ValueObject;

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\Weight;
use App\Domain\ValueObject\WeightUnits;

class WeightTest extends TestCase
{
    function testWeightCreation(): void
    {
        $weight = new Weight(1000, WeightUnits::GRAMS);
        $this->assertEquals(1000, $weight->getUnitValue());
        $this->assertEquals('1000.00 g', $weight->toString());

        $weight = new Weight(1, WeightUnits::KILOGRAMS);
        $this->assertEquals(1000, $weight->getUnitValue());
        $this->assertEquals('1.00 kg', $weight->toString());

        $weight = new Weight(2.20462, WeightUnits::POUNDS);
        $this->assertEqualsWithDelta(1000, $weight->getUnitValue(), 0.01);
        $this->assertEquals('2.20 lbs', $weight->toString());
    }

    function testNegativeWeightThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Weight(-100, WeightUnits::GRAMS);
    }
}
