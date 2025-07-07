<?php

declare(strict_types=1);

namespace App\Command;

use App\Domain\ValueObject\Weight;
use Symfony\Component\Validator\Constraints as Assert;

final class AddVegetableCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'Name cannot be blank.')]
        #[Assert\Length(min: 1, max: 150)]
        public readonly string $name,
        #[Assert\Valid]
        public readonly Weight $weight,
    ) {}
}
