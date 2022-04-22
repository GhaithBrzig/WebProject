<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/stats", name="evenement_stats")
     */
    public function statistics(EntityManagerInterface $entityManager): response
    {
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();



        $evenementName = [];
        $evenementCount = [];
        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($evenements as $evenement){
            $evenementName[] = $evenement->getType();
            $evenementCount[]= count($evenement->getReservations());
        }


        return $this->render('evenement/stats.html.twig', [
            'evenementName' => json_encode($evenementName),
            'evenementCount' => json_encode($evenementCount)

        ]);

    }
    /**
     * @Route("/liste/evenement", name="liste_evenement")
     */
    public function liste_evenement()
    {
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

        return $this->render('liste_evenement/index.html.twig',array( "evenements" => $evenement));

    }
    /**
     * @Route("/evenementBack", name="evenement_Back", methods={"GET"})
     */
    public function indexBack(EntityManagerInterface $entityManager, Request $request,PaginatorInterface $paginator): Response
    {
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();

        $evpagination = $paginator->paginate(
            $evenements, // on passe les donnees
            $request->query->getInt('page', 1),// Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5
        );

        return $this->render('evenement/evenementBack.html.twig', [
            'evenements' => $evpagination,

        ]);
    }
    /**
     * @Route("/", name="evenement_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $evenements = $entityManager
            ->getRepository(Evenement::class)
            ->findAll();

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }

    /**
     * @Route("/new", name="evenement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evenement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);

            $entityManager->flush();

            return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_delete", methods={"POST"})
     */
    public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $res = $this->getDoctrine()->getRepository(Evenement::class)->find($id);

        //  var_dump($res);
        $entityManager->remove($res);
        $entityManager->flush();


        return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);

    }
}
