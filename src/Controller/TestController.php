<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route(path: '/test')]
class TestController
{
    #[Route(path: '')]
    public function test(Request $request): JsonResponse
    {
        return new JsonResponse([
            'content' => $request->getContent(),
            'query' => $request->query->all(),
        ]);
    }
}
