<?php

namespace App\UI\Api\V1;

use App\Domain\ValueObject\Weight;
use App\Domain\ValueObject\WeightUnits;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class AbstractItemController extends AbstractController
{
    protected function extractWeightFromRequest(Request $request): Weight
    {
        $weightValue = $request->request->get('weight');
        $unit = $request->request->get('unit');

        return match ($unit) {
            'g' => new Weight($weightValue, WeightUnits::GRAMS),
            'kg' => new Weight($weightValue, WeightUnits::KILOGRAMS),
            default => throw new \InvalidArgumentException('Invalid unit: ' . $unit),
        };
    }

    protected function getQueryBus(): MessageBusInterface
    {
        return $this->container->get('messenger.bus.query.bus');
    }

    protected function getCommandBus(): MessageBusInterface
    {
        return $this->container->get('messenger.bus.command.bus');
    }
}
