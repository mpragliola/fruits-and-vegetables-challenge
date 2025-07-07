<?php

declare(strict_types=1);

namespace App\UI\Api\V1\DTO;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

final class AddVegetableRequestDTO extends AbstractAddItemRequest {}
