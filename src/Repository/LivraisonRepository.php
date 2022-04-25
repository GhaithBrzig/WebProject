<?php

namespace App\Repository;

use App\Entity\Livraison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livraison|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livraison|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livraison[]    findAll()
 * @method Livraison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivraisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livraison::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Livraison $entity, bool $flush = true): void
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
    public function remove(Livraison $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Livraison[] Returns an array of Livraison objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Livraison
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    function SearchName($nom)
    {
        $entityManager=$this->getEntityManager();
        $query=$entityManager
        ->createQuery("select sum(pr.prixProd * p.quantite) as tot ,l.idlivraison , li.nomlivreur as idlivreur , l.fraisdelivraison , IDENTITY(l.idCommande) as idCommande from App\Entity\Livraison l inner join App\Entity\Livreur li inner join App\Entity\Panier p inner join App\Entity\Produit pr where p.idCommande = l.idCommande and p.idProduit = pr.idProd and li.idlivreur = l.idlivreur and li.nomlivreur LIKE :nom   group by l.idlivraison")
        ->setParameter('nom', '%' . $nom . '%');
        return $query->getResult();
    }
    function Search($limit,$offset){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
        ->createQuery("select sum(pr.prixProd * p.quantite) as tot ,l.idlivraison , li.nomlivreur as idlivreur , l.fraisdelivraison , IDENTITY(l.idCommande) as idCommande from App\Entity\Livraison l inner join App\Entity\Livreur li inner join App\Entity\Panier p inner join App\Entity\Produit pr where p.idCommande = l.idCommande and p.idProduit = pr.idProd and li.idlivreur = l.idlivreur group by l.idlivraison ")
        ->setFirstResult($offset)
        ->setMaxResults($limit);
        return $query->getResult();
    }
    function Search2(){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
        ->createQuery("select sum(pr.prixProd * p.quantite) as tot ,l.idlivraison , li.nomlivreur as idlivreur , l.fraisdelivraison , IDENTITY(l.idCommande) as idCommande from App\Entity\Livraison l inner join App\Entity\Livreur li inner join App\Entity\Panier p inner join App\Entity\Produit pr where p.idCommande = l.idCommande and p.idProduit = pr.idProd and li.idlivreur = l.idlivreur group by l.idlivraison ");
     
        return $query->getResult();
    }
    function Search6(){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
        ->createQuery("select Count(l.idlivreur) as c, li.nomlivreur as nom from from App\Entity\Livraison l inner join App\Entity\Livreur li where l.idlivreur = li.idlivreur Group BY li.nomlivreur");
     
        return $query->getResult();
    }
}
