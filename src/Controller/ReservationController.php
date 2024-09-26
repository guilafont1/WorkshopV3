<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/mes_reservations', name: 'app_mes_reservations')]
    public function index(Request $request, ReservationRepository $reservationRepository): Response
    {
        // Obtenir l'utilisateur connecté
        $user = $this->getUser();

        // Termes de recherche envoyés via la requête
        $searchTerm = $request->query->get('search', '');

        // Filtrer les réservations par utilisateur et terme de recherche
        if ($searchTerm) {
            $reservations = $reservationRepository->findByUserAndSearchTerm($user, $searchTerm);
        } else {
            $reservations = $reservationRepository->findBy(['user' => $user]);
        }

        // Si c'est une requête AJAX, renvoyer uniquement le fragment HTML des résultats
        if ($request->isXmlHttpRequest()) {
            return $this->render('reservation/_reservation_list.html.twig', [
                'reservations' => $reservations,
            ]);
        }

        // Renvoyer la vue complète pour une requête normale
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
            'searchTerm' => $searchTerm,
        ]);
    }
}
