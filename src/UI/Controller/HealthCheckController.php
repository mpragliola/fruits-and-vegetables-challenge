<?php

declare(strict_types=1);

namespace App\UI\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController extends AbstractController
{
    #[Route('/api/v1/health', name: 'api_v1_health', methods: ['GET'])]
    public function __invoke(
        EntityManagerInterface $em,
    ): JsonResponse {

        // DB check
        try {
            $em->getConnection()->executeQuery('SELECT 1');
            $dbOk = true;
        } catch (\Throwable $e) {
            $dbOk = false;
        }

        return new JsonResponse([
            'status'    => $dbOk ? 'ok' : 'error',
            'app'       => 'ok',
            'db'        => $dbOk ? 'ok' : 'error',
            'timestamp' => (new \DateTime())->format(\DateTime::ATOM),
        ], $dbOk ? 200 : 503);
    }
}
