<?php

namespace App\Controller;

use App\Repository\LoanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ReservationController extends AbstractController
{
    #[Route('/mes-reservations', name: 'app_mes_reservations')]
    #[IsGranted('ROLE_USER')] // Assurez-vous que seuls les utilisateurs connectés peuvent voir cette page
    public function index(LoanRepository $loanRepository): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Récupérer les prêts (réservations) pour l'utilisateur
        $loans = $loanRepository->findByUser($user);

        return $this->render('reservation/index.html.twig', [
            'loans' => $loans,
        ]);
    }
}
