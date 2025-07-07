<?php

namespace App\UI\Api\V1;

use App\Command\AddFruitCommand;
use App\Domain\ValueObject\Weight;
use App\Domain\ValueObject\WeightUnits;
use App\Query\ListFruitQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/fruit')]
class FruitController extends AbstractItemController
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

    #[Route('', name: 'api_v1_fruit_add', methods: ['POST'])]
    public function add(
        Request $request,
    ): JsonResponse {
        $command = new AddFruitCommand(
            name: $request->request->get('name'),
            weight: $this->extractWeightFromRequest($request),
        );
        $this->queryBus->dispatch($command);

        return new JsonResponse(['status' => 'success'], JsonResponse::HTTP_CREATED);
    }
}
