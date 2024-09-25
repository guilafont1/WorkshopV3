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

        // Filtrer les équipements en fonction du terme de recherche
        if ($searchTerm) {
            $equipments = $equipmentRepository->findBySearchTerm($searchTerm);
        } else {
            $equipments = $equipmentRepository->findAll();
        }

        // Si c'est une requête AJAX, renvoyer uniquement le fragment HTML des résultats
        if ($request->isXmlHttpRequest()) {
            return $this->render('catalogue/_equipment_list.html.twig', [
                'equipments' => $equipments,
            ]);
        }

        // Renvoyer la vue complète pour une requête normale
        return $this->render('catalogue/index.html.twig', [
            'equipments' => $equipments,
            'searchTerm' => $searchTerm,
        ]);
    }
}
