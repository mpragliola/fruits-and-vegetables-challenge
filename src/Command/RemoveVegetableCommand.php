<?php

namespace App\Command\RemoveVegetableCommand;

use Symfony\Component\Validator\Constraints as Assert;

final class RemoveVegetableCommand
{
    public function __construct(
        #[Assert\NotBlank(message: 'ID cannot be blank.')]
        #[Assert\Uuid(message: 'ID must be a valid UUID.')]
        public readonly string $id,
    ) {}
}
