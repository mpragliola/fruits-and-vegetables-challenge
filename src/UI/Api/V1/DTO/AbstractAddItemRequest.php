<?php

declare(strict_types=1);

namespace App\UI\Api\V1\DTO;

use JMS\Serializer\Annotation as JMS;

abstract class AbstractAddItemRequest
{
    #[JMS\Type('string')]
    public string $name;

    #[JMS\Type('string')]
    #[\Symfony\Component\Validator\Constraints\Choice(choices: ['g', 'kg', 'lbs'])]
    public string $unit;

    #[JMS\Type('float')]
    #[\Symfony\Component\Validator\Constraints\Positive]
    public float $value;
}
