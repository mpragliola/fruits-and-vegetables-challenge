<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Weight;
use Symfony\Component\Uid\Uuid;

abstract class AbstractItem
{
    protected string $id;

    public function __construct(
        protected string $name,
        protected Weight $weight
    ) {
        $this->id = Uuid::v4()->toRfc4122();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getWeight(): Weight
    {
        return $this->weight;
    }

    public function setWeight(Weight $newWeight): self
    {
        $this->weight = $newWeight;

        return $this;
    }
}
