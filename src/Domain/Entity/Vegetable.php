<?php

declare(strict_types=1);

namespace App\Domain\Entity;


use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'vegetable')]
final class Vegetable extends AbstractItem {}
