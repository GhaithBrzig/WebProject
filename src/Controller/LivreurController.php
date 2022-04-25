<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Entity\Livreur;
use App\Form\LivreurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


/**
 * @Route("/livreur")
 */
class LivreurController extends AbstractController
{
    /**
     * @Route("/aaa", name="app_livreur_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $livreurs = $entityManager
            ->getRepository(Livreur::class)
            ->findAll();

        return $this->render('livreur/index.html.twig', [
            'livreurs' => $livreurs,
        ]);
    }

    /**
     * @Route("/new", name="addlivr", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livreur = new Livreur();
        $form = $this->createForm(LivreurType::class, $livreur);
        $form->add('Add Livreur', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livreur);
            $entityManager->flush();

            return $this->redirectToRoute('indexliv', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('LivreurAdd.html.twig', [
            'livreur' => $livreur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idlivreur}", name="app_livreur_show", methods={"GET"})
     */
    public function show(Livreur $livreur): Response
    {
        return $this->render('livreur/show.html.twig', [
            'livreur' => $livreur,
        ]);
    }

    /**
     * @Route("/editl/{id}", name="editl", methods={"GET", "POST"})
     */
    public function editl(Request $request,$id, EntityManagerInterface $entityManager): Response
    {
        $livreur = $this->getDoctrine()->getRepository(Livreur::class)->find($id);
        $form = $this->createForm(LivreurType::class, $livreur);
        $form->add('Update Livreur', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush($livreur);

            return $this->redirectToRoute('indexliv');
        }

        return $this->render('livreur/edit.html.twig', [
            'livreur' => $livreur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idlivreur}", name="app_livreur_delete", methods={"POST"})
     */
    public function delete(Request $request, Livreur $livreur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livreur->getIdlivreur(), $request->request->get('_token'))) {
            $entityManager->remove($livreur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_livreur_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     *  @Route("/Deleteliv/{id}", name="Deleteliv")
     */
    public function Deleteliv($id)
    {
        $livreur = $this->getDoctrine()->getRepository(Livreur::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($livreur);
        $em->flush();
        return $this->redirectToRoute("indexliv");
    }
   
}


