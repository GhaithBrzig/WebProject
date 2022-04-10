<?php

namespace App\Repository;

use App\Entity\Repa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Repa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repa[]    findAll()
 * @method Repa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repa::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Repa $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Repa $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function updateNullCategorie(){  
        $updateCat = $this->createQueryBuilder('r')
                    ->update(Repa::class, 'r')
                    ->set('r.categorie', '?1')
                    ->where('r.categorie is NULL')
                    ->setParameter(1, 'autre')
                    ->getQuery();
               // var_dump($updateCat);
                $updateCat->execute();
               
    }

    
/*
    public function listPlat(){
        return $this->createQueryBuilder('r')
        ->where('r.categorie LIKE ?1')
        ->setParameter('1', 'plat%')
        ->getQuery()
        ->getResult();
    }*/
    // /**
    //  * @return Repa[] Returns an array of Repa objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Repa
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
