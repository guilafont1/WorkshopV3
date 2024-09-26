<?php

namespace App\Controller;

use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(Request $request, EquipmentRepository $equipmentRepository): Response
    {
        $searchTerm = $request->query->get('search', '');

        if ($searchTerm) {
            $equipments = $equipmentRepository->findBySearchTerm($searchTerm);
        } else {
            $equipments = $equipmentRepository->findAll();
        }

        if ($request->isXmlHttpRequest()) {
            return $this->render('catalogue/_equipment_list.html.twig', [
                'equipments' => $equipments,
            ]);
        }

        return $this->render('catalogue/index.html.twig', [
            'equipments' => $equipments,
            'searchTerm' => $searchTerm,
        ]);
    }
}
