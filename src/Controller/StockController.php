<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\Stockcategory;
use App\Form\StockFType;
use App\Service\MailerService;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class StockController extends AbstractController
{
    /**
     * @Route("/stockaq", name="app_stock")
     */
    public function index(): Response
    {
        return $this->render('stock/index.html.twig', [
            'controller_name' => 'StockController',
        ]);
    }



    /**
     *  @Route("/stocka", name="stocka")
     */
    public function DisplayStock()
    {
        $produit = $this->getDoctrine()->getRepository(Stock::class)->findAll();
        $category = $this->getDoctrine()->getRepository(StockCategory::class)->findAll();
        return $this->render('stock.html.twig', ['produits' => $produit, 'categories' => $category]);
    }



    /**
     *  @Route("stock/delete/{id}", name="del")
     */
    public function Delete($id)
    {
        $produit = $this->getDoctrine()->getRepository(Stock::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("stock");
    }



    /**
     *  @Route("/stock/add", name="addStock")
     */
    public function Add(HttpFoundationRequest $request)
    {
        $produit = new Stock();
        $form = $this->createForm(StockFType::class, $produit);
        $form->add('Add Product', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $event->setPrixTotal($event->getPrixUnitaire() * $event->getQuantite());
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('stock');
        }
        return $this->render('addStock.html.twig', [
            'form' => $form->createView()
        ]);
    }




    /**
     *  @Route("/stock/Update/{id}", name="Upd")
     */
    public function Update($id, HttpFoundationRequest $request, MailerService $mailer)
    {
        $produit = $this->getDoctrine()->getRepository(Stock::class)->find($id);
        $form = $this->createForm(StockFType::class, $produit);
        $form->add('Update Product', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $event->setPrixTotal($event->getPrixUnitaire() * $event->getQuantite());
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            if ($produit->getQuantite() < 6) {
                $msg =  $produit->getNom() . ' ' . 'is getting exhausted !';
                $mailer->sendEmail($msg, 'Stock Warning !');
            }
            return $this->redirectToRoute('stock');
        }
        return $this->render('stockUpdate.html.twig', [
            'f' => $form->createView()
        ]);
    }

    /**
     *  @Route("/stock/Search", name="SEARCH1")
     */
    function Search(StockRepository $repository, HttpFoundationRequest $request)
    {
        $data = $request->get('search');
        $produit = $repository->findBy(['nom' => $data]);
        $category = $this->getDoctrine()->getRepository(StockCategory::class)->findAll();
        return $this->render('stock.html.twig', ['produits' => $produit, 'categories' => $category]);
    }

    /**
     * @param StockRepository $repository
     * @param Request $request
     * @return Response
     *  @Route("/stock/SearchName", name="SEARCH")
     */
    function SearchName(StockRepository $repository, HttpFoundationRequest $request)
    {
        $name = $request->get('search');
        $produit = $repository->SearchName($name);
        $category = $this->getDoctrine()->getRepository(StockCategory::class)->findAll();
        return $this->render('stock.html.twig', ['produits' => $produit, 'categories' => $category, 'isPaginated' => false]);
    }

    /**
     *  @Route("/stock/{page?1}/{nbre?5}", name="stock")
     */
    public function DisplayStock2(StockRepository $repository, $page, $nbre)
    {
        $nbProduit = $repository->count([]);
        $nbPage =  ceil($nbProduit / $nbre);
        $produit = $repository->findBy([], [], $nbre, ($page - 1) * $nbre);
        $category = $this->getDoctrine()->getRepository(StockCategory::class)->findAll();
        return $this->render('stock.html.twig', [
            'produits' => $produit,
            'categories' => $category,
            'isPaginated' => true,
            'nbrePage' => $nbPage,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }

    /**
     *  @Route("/stockq/{page?1}/{nbre?500}", name="stock2")
     */
    public function DisplayStockq(StockRepository $repository, $page, $nbre)
    {
        $nbProduit = $repository->count([]);
        $nbPage =  ceil($nbProduit / $nbre);
        $produit = $repository->findBy([], ["quantite" => "asc"], $nbre, ($page - 1) * $nbre);
        $category = $this->getDoctrine()->getRepository(StockCategory::class)->findAll();
        return $this->render('stock.html.twig', [
            'produits' => $produit,
            'categories' => $category,
            'isPaginated' => false,
            'nbrePage' => $nbPage,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }
    /**
     *  @Route("/stockn/{page?1}/{nbre?500}", name="stock3")
     */
    public function DisplayStockn(StockRepository $repository, $page, $nbre)
    {
        $nbProduit = $repository->count([]);
        $nbPage =  ceil($nbProduit / $nbre);
        $produit = $repository->findBy([], ["nom" => "asc"], $nbre, ($page - 1) * $nbre);
        $category = $this->getDoctrine()->getRepository(StockCategory::class)->findAll();
        return $this->render('stock.html.twig', [
            'produits' => $produit,
            'categories' => $category,
            'isPaginated' => false,
            'nbrePage' => $nbPage,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }
    /**
     *  @Route("/stockc/{page?1}/{nbre?500}", name="stock4")
     */
    public function DisplayStockc(StockRepository $repository, $page, $nbre)
    {
        $nbProduit = $repository->count([]);
        $nbPage =  ceil($nbProduit / $nbre);
        $produit = $repository->findBy([], ["idCategorie" => "asc"], $nbre, ($page - 1) * $nbre);
        $category = $this->getDoctrine()->getRepository(StockCategory::class)->findAll();
        return $this->render('stock.html.twig', [
            'produits' => $produit,
            'categories' => $category,
            'isPaginated' => false,
            'nbrePage' => $nbPage,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }
}
