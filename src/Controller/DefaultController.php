<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }


    /**
     * @Route("/products", name="products")
     */
    public function products(): Response
    {
        return $this->render('products.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/accounts", name="accounts")
     */
    public function accounts(): Response
    {
        return $this->render('accounts.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }



    /**
     * @Route("/addProduct", name="addProduct")
     */
    public function addProduct(): Response
    {
        return $this->render('addProduct.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('login.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
