<?php

namespace App\Repository;

use App\Entity\Equipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EquipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipment::class);
    }

    // Méthode pour chercher des équipements par terme de recherche
    
    public function findBySearchTerm(string $term)
{
    return $this->createQueryBuilder('e')
        ->andWhere('e.name LIKE :term OR e.description LIKE :term')
        ->setParameter('term', '%' . $term . '%')
        ->getQuery()
        ->getResult();
}

}
