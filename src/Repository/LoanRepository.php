<?php

namespace App\Repository;

use App\Entity\Loan;
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
    public function findByUser($user)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.user_id = :user')
            ->setParameter('user', $user)
            ->orderBy('l.start_time', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
