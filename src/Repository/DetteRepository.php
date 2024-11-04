<?php

namespace App\Repository;

use App\Entity\Dette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dette>
 *
 * @method Dette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dette[]    findAll()
 * @method Dette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
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

    /**
     * Finds debts based on filters such as client, date, and status.
     * 
     * @param array $filters An associative array containing the filters.
     * @return Dette[] Returns an array of Dette objects.
     */
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
            $qb->andWhere('d.DateAt = :date') // Utiliser '=' pour une date précise
               ->setParameter('date', $filters['date']);
        }

        if (isset($filters['statut'])) {
            if ($filters['statut'] === 'soldé') {
                $qb->andWhere('d.montantVerse = d.montant'); // Tous les montants versés
            } elseif ($filters['statut'] === 'non soldé') {
                $qb->andWhere('d.montantVerse < d.montant'); // Montants non versés
            }
        }

        return $qb->getQuery()->getResult();
    }
}
