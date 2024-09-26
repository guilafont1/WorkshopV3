<?php

namespace App\Controller;

use App\Repository\LoanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\User; // Ajoute cette ligne pour s'assurer que User est importé

class ReservationController extends AbstractController
{
    #[Route('/mes-reservations', name: 'app_mes_reservations')]
    #[IsGranted('ROLE_USER')] // Assurez-vous que seuls les utilisateurs connectés peuvent voir cette page
    public function index(LoanRepository $loanRepository): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifie si l'utilisateur est bien de type User
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Récupérer les prêts (réservations) pour l'utilisateur
        $loans = $loanRepository->findBy(['user' => $user]); // Utilise un tableau associatif pour rechercher par 'user'

        return $this->render('reservation/index.html.twig', [
            'loans' => $loans,
        ]);
    }
}
