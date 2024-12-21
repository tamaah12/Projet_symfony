<?php

namespace App\Repository;

use App\Entity\Dette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class DetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dette::class);
    }

    public function add(Dette $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Dette $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
    public function findByFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('d')
                   ->leftJoin('d.client', 'c')
                   ->addSelect('c');

        if (!empty($filters['client'])) {
            $qb->andWhere('d.client = :client')
               ->setParameter('client', $filters['client']);
        }

        if (!empty($filters['date'])) {
            $qb->andWhere('d.DateAt = :date')
               ->setParameter('date', $filters['date']);
        }

        if (isset($filters['statut'])) {
            if ($filters['statut'] === 'soldé') {
                $qb->andWhere('d.montantVerse = d.montant');
            } elseif ($filters['statut'] === 'non soldé') {
                $qb->andWhere('d.montantVerse < d.montant');
            }
        }

        return $qb->getQuery()->getResult();
    }
}
