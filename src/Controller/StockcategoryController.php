<?php

namespace App\Controller;

use App\Entity\Stockcategory;
use App\Form\StockcategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockcategoryController extends AbstractController
{
    /**
     * @Route("/stockcategory", name="app_stockcategory")
     */
    public function index(): Response
    {
        return $this->render('stockcategory/index.html.twig', [
            'controller_name' => 'StockcategoryController',
        ]);
    }

    /**
     *  @Route("/DisplayStockcategory", name="DisplayStockcategory")
     */
    public function DisplayStockcategory()
    {
        $categorie = $this->getDoctrine()->getRepository(Stockcategory::class)->findAll();
        return $this->render('stockcategory/Stockcategory.html.twig', ['categories' => $categorie]);
    }

    /**
     *  @Route("/Deletec/{id}", name="Delc")
     */
    public function Deletec($id)
    {
        $categorie = $this->getDoctrine()->getRepository(Stockcategory::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("stock");
    }



    /**
     *  @Route("/stock/Updatec/{id}", name="Updc")
     */
    public function Update($id, Request $request)
    {
        $categorie = $this->getDoctrine()->getRepository(Stockcategory::class)->find($id);
        $form = $this->createForm(StockcategoryType::class, $categorie);
        $form->add('Update Category', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('stock');
        }
        return $this->render('UpdateStockCategory.html.twig', [
            'f' => $form->createView()
        ]);
    }


    /**
     *  @Route("/stock/Addc", name="Addc")
     */
    public function Addc(Request $request)
    {
        $categorie = new Stockcategory();
        $form = $this->createForm(StockcategoryType::class, $categorie);
        $form->add('Add Category', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('stock');
        }
        return $this->render('addStockCategory.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
