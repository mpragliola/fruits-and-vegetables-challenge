<?php

declare(strict_types=1);

namespace App\Command;

final class ParseItemCollectionCommand
{
    public function __construct(
        public readonly string $jsonBlob,
    ) {}
}
