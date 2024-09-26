<?php

namespace App\Repository;

use App\Entity\Loan;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Loan>
 */
class LoanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Loan::class);
    }

    // Méthode personnalisée pour récupérer les prêts de l'utilisateur connecté
    public function findByUser(User $user): array
{   
    return $this->createQueryBuilder('l')
        ->andWhere('l.user = :user')
        ->setParameter('user', $user)
        ->getQuery()
        ->getResult();
    }
}
