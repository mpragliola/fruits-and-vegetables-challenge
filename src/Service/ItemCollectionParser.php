<?php

declare(strict_types=1);

namespace App\Service;

use App\Command\ParseItemCollectionCommand;
use App\Domain\Entity\AbstractItem;
use App\Domain\Entity\Fruit;
use App\Domain\Entity\Vegetable;
use App\Domain\ValueObject\Weight;
use App\Domain\ValueObject\WeightUnits;

class ItemCollectionParser
{
    /**
     * @return AbstractItem[]
     */
    public function parse(string $jsonBlob): array
    {
        $data = json_decode($jsonBlob, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON provided: ' . json_last_error_msg());
        }

        $parsed = array_map(
            fn(array $item) => $this->itemParser($item),
            $data ?? []
        );

        if (empty($parsed)) {
            throw new \InvalidArgumentException('No items found in the provided JSON.');
        }

        return $parsed;
    }

    private function itemParser(array $item): AbstractItem
    {
        return match ($item['type']) {
            'fruit' => new Fruit(
                name: $item['name'],
                weight: new Weight(
                    value: $item['quantity'],
                    unit: WeightUnits::from($item['unit']),
                )
            ),
            'vegetable' => new Vegetable(
                name: $item['name'],
                weight: new Weight(
                    value: $item['quantity'],
                    unit: WeightUnits::from($item['unit']),
                ),
            ),
            default => throw new \InvalidArgumentException('Unknown item type: ' . $item['type']),
        };
    }
}
