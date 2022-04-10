<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Repa;
use App\Entity\Categories;
use App\Form\MenuType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MenuController extends AbstractController
{

/**
 * @Route("/menu", name="displayMenu")
 */
    public function displayMenu(Request $request)
    {
        $categorie = $this->getDoctrine()->getRepository(Categories::class)->findAll();
        $repa = $this->getDoctrine()->getRepository(Repa::class)->findAll();
        $form = $this->createForm(MenuType::class);
        
        $x = 0;
        
        foreach( $categorie as $i ){
            $values[$categorie[$x]->getCategorie()] = implode((array) $categorie[$x]->getCategorie());
            
           $x++;
        }
        $values["All"] = "All";
           $form->add("catg",ChoiceType::class,
           array('choices' => $values
        )
    );
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('Select')){
                $selected = $form->get('catg')->getData();
                if($selected == 'All')
                $repa=$this->getDoctrine()->getRepository(Repa::class)->findAll();
                else
                $repa=$this->getDoctrine()->getRepository(Repa::class)->findBy(['categorie' => $selected]);
              }

              //$repa=$this->getDoctrine()->getRepository(Repa::class)->findBy(array('categorie' =>'plat'));
        }
        return $this->render('menu/menu.html.twig',array('form' => $form->createView(),"repas" => $repa , "categories" => $categorie));

    }



}
