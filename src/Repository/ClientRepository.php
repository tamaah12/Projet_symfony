<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function add(Client $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Client $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
    public function findByFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('c');

        if (!empty($filters['surname'])) {
            $qb->andWhere('c.surname LIKE :surname')
               ->setParameter('surname', '%' . $filters['surname'] . '%');
        }

        if (!empty($filters['telephone'])) {
            $qb->andWhere('c.telephone LIKE :telephone')
               ->setParameter('telephone', '%' . $filters['telephone'] . '%');
        }


        if (isset($filters['accountStatus'])) {
            if ($filters['accountStatus'] === 'with_account') {
                $qb->andWhere('c.compte IS NOT NULL');
            } elseif ($filters['accountStatus'] === 'without_account') {
                $qb->andWhere('c.compte IS NULL');
            }
        }

        return $qb->getQuery()->getResult();
    }
}
