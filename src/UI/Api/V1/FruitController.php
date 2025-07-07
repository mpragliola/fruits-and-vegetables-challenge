<?php

namespace App\UI\Api\V1;

use App\Query\ListFruitQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Service\Attribute\Required;

#[Route('/api/v1/fruit')]
class FruitController extends AbstractController
{
    public function __construct(
        private MessageBusInterface $queryBus,
    ) {}

    #[Route('', name: 'api_v1_fruit_search', methods: ['GET'])]
    public function search(
        Request $request,
    ): JsonResponse {
        $query = new ListFruitQuery(
            filter: new \App\Query\Filter\ListFruitQueryFilter(
                name: $request->query->get('name'),
                minWeight: $request->query->get('minWeight'),
                maxWeight: $request->query->get('maxWeight'),
            ),
        );

        $envelope = $this->queryBus->dispatch($query);
        $stamp = $envelope->last(HandledStamp::class);
        if (!$stamp) {
            throw new \RuntimeException('No handler found for the query.');
        }
        if (!$stamp instanceof HandledStamp) {
            throw new \RuntimeException('Expected a HandledStamp, got ' . get_class($stamp));
        }
        $fruits = $stamp->getResult();

        return $this->json($fruits);
    }
}
