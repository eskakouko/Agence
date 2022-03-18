<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @return Property[] Returns an array of Property objects
     */
    public function findAllVisible(): array
    {
        return $this->findVisibleQuery()
                    ->orderBy('p.id', 'DESC')
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
     * @return Property[] Returns an array of Property objects
     */
    public function findLatesst(): array
    {
        return $this->findVisibleQuery()
                    ->setMaxResults(4)
                    ->orderBy('p.id', 'DESC')
                    ->getQuery()
                    ->getResult()
        ;
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
                    ->where('p.sold = false')
        ;
    }

    
}
