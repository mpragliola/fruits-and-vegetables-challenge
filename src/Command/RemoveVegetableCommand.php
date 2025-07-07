<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Validator\Constraints as Assert;

final class RemoveVegetableCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'ID cannot be blank.')]
        #[Assert\Uuid(message: 'ID must be a valid UUID.')]
        public readonly string $id,
    ) {}
}
