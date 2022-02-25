<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GlobalStatController extends AbstractController
{
    #[Route('/api/global-stat', name: 'global_stat')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(Request $request, AnimalRepository $animalRepository): Response
    {
        $response = new JsonResponse([
            'total_animals' => $animalRepository->countAll(),
            'total_animals_without_owner' => $animalRepository->countAllWithoutOwner(),
        ]);

        return  $response;
    }
}
