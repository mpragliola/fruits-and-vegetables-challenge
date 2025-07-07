<?php

namespace App\UI\Api\V1;

use App\Command\AddFruitCommand;
use App\Domain\ValueObject\Weight;
use App\Domain\ValueObject\WeightUnits;
use App\Query\ListFruitQuery;
use App\UI\Api\V1\DTO\AddFruitRequestDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface as JmsSerializer;
use Symfony\Component\Messenger\MessageBusInterface;

#[Route('/api/v1/fruit')]
class FruitController extends AbstractItemController
{
    public function __construct(
        private JMSSerializer $serializer,
        private MessageBusInterface $commandBus,
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
        $dto = $this->serializer->deserialize(
            $request->getContent(),
            AddFruitRequestDTO::class,
            'json',
        );

        $command = new AddFruitCommand(
            name: $dto->name,
            weight: new Weight($dto->value, WeightUnits::from($dto->unit)),
        );
        $this->commandBus->dispatch($command);

        return new JsonResponse(['status' => 'success'], JsonResponse::HTTP_CREATED);
    }
}
