<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livraison;
use App\Repository\LivraisonRepository;
use Doctrine\ORM\EntityManagerInterface;



class LivraisonFrontController extends AbstractController
{
   /**
    * @Route("livraisonfront", name="Displaylivraisons")
    */
   public function DisplayLivraisons(LivraisonRepository $repository,EntityManagerInterface $entityManager)
   {
       $livraisons = $repository->Search2(); 
    return $this->render('livraison_front/index.html.twig',['livraisons' => $livraisons]);
   }
}
