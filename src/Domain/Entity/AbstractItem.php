<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Weight;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class AbstractItem
{
    #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
    public string $id;

    public function __construct(
        #[ORM\Column(type: 'string', length: 150)]
        public string $name,
        #[ORM\Embedded(class: Weight::class)]
        public Weight $weight
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
