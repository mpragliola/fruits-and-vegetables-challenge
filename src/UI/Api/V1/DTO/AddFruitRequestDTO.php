<?php

declare(strict_types=1);

namespace App\UI\Api\V1\DTO;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

final class AddFruitRequestDTO
{
    #[JMS\Type('string')]
    public string $name;

    #[JMS\Type('string')]
    #[Assert\Choice(choices: ['g', 'kg', 'lbs'])]
    public string $unit;

    #[JMS\Type('float')]
    #[Assert\Positive]
    public float $value;
}
