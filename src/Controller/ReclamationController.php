<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Service\MailService;
use App\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation", name="app_reclamation")
     */
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }

    /**
     *  @Route("/DisplayReclamation", name="DisplayReclamation")
     */
    public function DisplayReclamation()
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        return $this->render('reclamations.html.twig', ['reclamations' => $reclamation]);
    }

    /**
     *  @Route("/Deleter/{id}", name="Delr")
     */
    public function Deleter($id)
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("DisplayReclamation");
    }

    /**
     *  @Route("/reclamation/Add", name="addr")
     */
    public function Add(Request $request)
    {
        $time = new \DateTime();
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $event->setDate($time);
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('index');
        }
        return $this->render('Front/Reclamation.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *  @Route("/reclamation/Updater/{id}", name="Updr")
     */
    public function Update($id, Request $request)
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('DisplayReclamation');
        }
        return $this->render('reclamation/Updater.html.twig', [
            'f' => $form->createView()
        ]);
    }
    /**
     *  @Route("/reclamation/solve/{id}", name="solve")
     */
    function Solve($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reclamation = $entityManager->getRepository(Reclamation::class)->find($id);
        $reclamation->setIssolved(1);
        $entityManager->flush();
        return $this->redirectToRoute("DisplayReclamation");
    }
}
