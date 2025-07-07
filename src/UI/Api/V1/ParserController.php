<?php

declare(strict_types=1);

namespace App\UI\Api\V1;

use App\Command\ParseItemCollectionCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ParserController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus
    ) {}

    #[Route('/api/v1/parse', name: 'api_v1_parse', methods: ['POST'])]
    public function parseItems(Request $request): JsonResponse
    {
        $this->commandBus->dispatch(
            new ParseItemCollectionCommand(
                $request->getContent()
            )
        );

        return new JsonResponse(
            ['status' => 'Items are being parsed'],
            JsonResponse::HTTP_ACCEPTED
        );
    }
}
