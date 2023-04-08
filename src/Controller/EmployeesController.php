<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EmployeesController extends AbstractController
{
    #[Route('/employees/{id}', name: 'employees', defaults: ['id' => null], methods:['GET', 'HEAD'])]
    public function index($id): JsonResponse
    {
        return $this->json([
            'message' => $id,
            'path' => 'src/Controller/EmployeesController.php',
        ]);
    }
}
