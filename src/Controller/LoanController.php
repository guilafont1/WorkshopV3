<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Entity\Equipment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LoanController extends AbstractController
{
    #[Route('/reserve/{id}', name: 'app_reserve')]
    #[IsGranted('ROLE_USER')] // S'assure que seul un utilisateur connecté peut réserver
    public function reserve(Equipment $equipment, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si l'équipement est disponible
        if (!$equipment->isAvailable()) {
            $this->addFlash('danger', 'Cet équipement n\'est pas disponible.');
            return $this->redirectToRoute('app_catalogue');
        }

        // Créer un nouveau prêt
        $loan = new Loan();
        $loan->setUser($this->getUser()); // L'utilisateur connecté
        $loan->setEquipment($equipment);
        $loan->setStartTime(new \DateTime());
        $loan->setEndTime((new \DateTime())->modify('+7 days'));
        $loan->setStatus(true);
        $loan->setCreatedAt(new \DateTime());

        // Marquer l'équipement comme indisponible
        $equipment->setAvailable(false);

        // Persister le prêt et l'équipement dans la base de données
        $entityManager->persist($loan);
        $entityManager->persist($equipment); // N'oublie pas de persister l'équipement
        $entityManager->flush();

        // Ajouter un message de succès
        $this->addFlash('success', 'L\'équipement a été réservé avec succès.');

        // Rediriger vers la page des réservations
        return $this->redirectToRoute('app_mes_reservations');
    }
}
