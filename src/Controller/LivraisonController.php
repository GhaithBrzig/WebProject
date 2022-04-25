<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Entity\Livreur;
use App\Form\LivraisonType;
use App\Repository\LivraisonRepository;
use App\Repository\LivreurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;


class LivraisonController extends AbstractController
{
    /**
     * @Route("/indexliv/{page?1}/{nbre?3}", name="indexliv", methods={"GET"})
     */
    public function affichage(LivraisonRepository $repository,EntityManagerInterface $entityManager, $page, $nbre): Response
    {
        $nbLivraison=$repository->count([]);
        $nbPage= ceil($nbLivraison / $nbre);
        $livraisons = $repository->Search($nbre,($page - 1) * $nbre );
            $livreur = $entityManager
            ->getRepository(Livreur::class)
            ->findAll();

        return $this->render('Delivery.html.twig', [
            'isPaginated' => true,
            'nbrePage' => $nbPage,
            'page' => $page,
            'nbre' => $nbre,
            'livraisons' => $livraisons,
            'livreurs' => $livreur
        ]);
    }

     /**
     * @Route("/indexlivN/{page?1}/{nbre?3}", name="indexlivN", methods={"GET"})
     */
    public function affichageByName(LivraisonRepository $repository,EntityManagerInterface $entityManager, $page, $nbre): Response
    {
        $nbLivraison=$repository->count([]);
        $nbPage= ceil($nbLivraison / $nbre);
        $livraisons = $repository->Search($nbre,($page - 1) * $nbre );
            $livreur = $entityManager
            ->getRepository(Livreur::class)
            ->findBy([],["nomlivreur" => "asc"]);

        return $this->render('Delivery.html.twig', [
            'isPaginated' => true,
            'nbrePage' => $nbPage,
            'page' => $page,
            'nbre' => $nbre,
            'livraisons' => $livraisons,
            'livreurs' => $livreur
        ]);
    }
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
    
        return $this->render('index.html.twig');
    }


    /**
     * @Route("/admin", name=" ", methods={"GET"})
     */
    public function indexAdmin(EntityManagerInterface $entityManager): Response
    {
        

        return $this->render('Livraison/index.html.twig');
    }

    /**
     * @Route("add", name="addLiv", methods={"GET" , "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livraison = new Livraison();
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->add('Add Delivery', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livraison);
            $entityManager->flush();

            return $this->redirectToRoute('indexliv', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('DeliveryAdd.html.twig', [
            'livraison' => $livraison,
            'form' => $form->createView(),
        ]);
    }

        


    /**
     
     */
    public function show(Livraison $livraison): Response
    {
        return $this->render('livraison/show.html.twig', [
            'livraison' => $livraison,
        ]);
    }
 /**
     * @Route("/edit/{id}", name="edit" ,methods={"GET", "POST"})
     */
   
   
    public function edit(Request $request, $id): Response
 
    {   
        $livraison = $this->getDoctrine()->getRepository(Livraison::class)->find($id);
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->add('Update Delivery', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush($livraison);

            return $this->redirectToRoute('indexliv');
        }

        
            return $this->render('Livraison/edit.html.twig', [
                'livraison' => $livraison,
                'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idlivraison}", name="deletel1", methods={"POST"})
     */
    public function delete(Request $request, Livraison $livraison, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livraison->getIdlivraison(), $request->request->get('_token'))) {
            $entityManager->remove($livraison);
            $entityManager->flush();
        }

        return $this->redirectToRoute('indexliv', [], Response::HTTP_SEE_OTHER);
    }
   /**
     *  @Route("/Deletel/{id}", name="Deletel")
     */
    public function Deletel($id)
    {
        
        $livraison= $this->getDoctrine()->getRepository(Livraison::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($livraison);
        $em->flush();
        return $this->redirectToRoute("indexliv");
    }
    /**
     * @param LivraisonRepository $repository
     * @param Request $request
     * @return Response
     *  @Route("/livraison/SearchName", name="SEARCH")
     */
    function SearchName(LivraisonRepository $repository,Request $request, EntityManagerInterface $entityManager)
    {
        $name = $request->get('search');
        $livraisons = $repository->SearchName($name);
        $livreur = $entityManager
        ->getRepository(Livreur::class)
        ->findAll();

    return $this->render('Delivery.html.twig', [
        'isPaginated' => false,
        'livraisons' => $livraisons,
        'livreurs' => $livreur
    ]);
}
 /**
     * @param LivraisonRepository $repository
     *  @Route("/livraison/livraison/data/download", name="livraison_data_download")
     */

    public function livraisonDataDownload(LivraisonRepository $repository)
    {
       
        //$livraison=$repository->find($id);
        //return $this->render('livraison/list.html.twig');
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
        'ssl' => [
           'verify_peer' => FALSE,
           'verify_peer-name' => FALSE,
           'allow_slef_signed' => TRUE
         ]
        ]);

        $dompdf->setHttpContext($context);

        $html = $this->renderView('livraison/download.html.twig', [
            'livraison' => $repository->Search2(),
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'Portrait');
        $dompdf->render();

        $fichier = 'Listes-des-livraisons.pdf';

        $dompdf->stream($fichier, [
            'Attachement' => true
        ]);

        return new Response();
    }

/**
     * @Route("/stats", name="livraison_stats")
     */
    public function statistics(EntityManagerInterface $entityManager): response
    {
        $livreurs = $entityManager
            ->getRepository(Livreur::class)
            ->findAll();



        $livreurName = [];
        $livraisonCount = [];
        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($livreurs as $livreur){
            $livreurName[] = $livreur->getNomlivreur();
            $livraisonCount[]= count($livreur->getLivraisons());
        }


        return $this->render('index.html.twig', [
            'livreurName' => json_encode($livreurName),
            'livraisonCount' => json_encode($livraisonCount)

        ]);

    }   
}


