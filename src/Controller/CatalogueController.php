<?php

namespace App\Controller;

use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(EquipmentRepository $equipmentRepository): Response
    {
        // Récupérer tous les équipements
        $equipments = $equipmentRepository->findAll();

        // Renvoyer la vue du catalogue avec les équipements
        return $this->render('catalogue/index.html.twig', [
            'equipments' => $equipments,
        ]);
    }
}
