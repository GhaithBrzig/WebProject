<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Repa;
use App\Entity\Categories;
use App\Form\CategorieType;
use App\Form\RepaType;
use App\Form\EditRepaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;


class RepasController extends AbstractController
{
/**
 * @Route("/repa", name="repa")
 */
public function displayRepas()
{
    $repa=$this->getDoctrine()->getRepository(Repa::class)->findAll();
    $categorie=$this->getDoctrine()->getRepository(Categories::class)->findAll();
    
    return $this->render('admin/Repas.html.twig',array("repas" => $repa,"categories" => $categorie));
    
}

/**
 * @Route("/deleteCategorie/{id}", name="deleteCategorie")
 */
public function deleteCategorie($id)
{
    $categorie = $this->getDoctrine()->getRepository(Categories::class)->find($id);
    $em = $this->getDoctrine()->getManager();
    $em->remove($categorie);
    $em->flush();
     $this->getDoctrine()->getRepository(Repa::class)->updateNullCategorie();
  
  $this->addFlash(
    'cat_delete',
    'Categorie is deleted!'
   );
    return $this->redirectToRoute("repa");
}

/**
 * @Route("/addCategorie", name="addCategorie")
 */
public function addCategorie(Request $request) : Response
{
    $categories = new Categories();
   $form = $this->createForm(CategorieType::class, $categories);
   $form->add('Add Categorie',SubmitType::class, array( 
    'attr'   =>  array(
        'class'   => 'btn btn-primary btn-block text-uppercase')   
    )
);
   $request->setMethod("POST");
   $form->handleRequest($request);
   if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($categories);
      $em->flush();
      $this->addFlash(
        'cat_add',
        'Categorie is saved'
    );
      return $this->redirectToRoute('repa');
        }
        
    return $this->render('admin/addCategorie.html.twig',array('form' => $form->createView(), 'test' => $request ));
}

/**
 * @Route("/addRepa", name="addRepa")
 */
public function addProduct(Request $request){
    $filesystem = new Filesystem();

    $em = $this->getDoctrine()->getRepository(Categories::class)->findAll();
    $x = 0;
    foreach($em as $i ){
    $categorie[$em[$x]->getCategorie()] = implode((array) $em[$x]->getCategorie());
   // $flipped[$x] = array_flip($categorie[$x]);
    $x++;
    }
    
    $repa = new Repa();
    //var_dump($flipped);
    $form = $this->createForm(RepaType::class,$repa);
   // var_dump($categorie);
    $form->add('categorie',ChoiceType::class, array(
        'label' => 'Categorie',
        'choices' => $categorie,
        'attr' => array(
            'class' => 'custom-select tm-select-accounts'
        )
    ));

    $form->add('AddProduct',SubmitType::class, array( 
        'label' => 'Add Product Now',
        
        'attr'   =>  array(
            'class'   => 'btn btn-primary btn-block text-uppercase')   
            
        ), 
        
    );
  //  $request->setMethod("POST");
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
       // $form->get('lib_prod')->getData();

       
       $path =  $form->get('path')->getData();
       $lib = $form->get('lib_prod')->getData();
       $filesystem->copy($path->getpathName(), "FrontOffice/images/Repas/$lib.png", true);
       $repa->setPath("FrontOffice/images/Repas/$lib.png"); 

       $em = $this->getDoctrine()->getManager();
       $em->persist($repa);
       $em->flush();
       $this->addFlash(
        'repa_add',
        'Repa added'
       );
       return $this->redirectToRoute('repa');
          }
    return $this->render('admin/addRepa.html.twig',array('form' => $form->createView()));
}


/**
 * @Route("/editRepa/{id}", name="editRepa")
 */
public function editRepa(Request $request,$id){
    $repa = $this->getDoctrine()->getRepository(Repa::class)->find($id);
    $clone = clone($repa);
    $path= $repa->getPath();
    $form = $this->createForm(EditRepaType::class,$repa);
    
    $catdb = $this->getDoctrine()->getRepository(Categories::class)->findAll();
    $x = 0;
    foreach($catdb as $i ){
    $categorie[$catdb[$x]->getCategorie()] = implode((array) $catdb[$x]->getCategorie());
   // $flipped[$x] = array_flip($categorie[$x]);
    $x++;
    }

    $form->add('categorie',ChoiceType::class, array(
        'label' => 'Categorie',
        'choices' => $categorie,
        'attr' => array(
            'class' => 'custom-select tm-select-accounts'
        )
    ));

    $form->add('AddProduct',SubmitType::class, array( 
        'label' => 'Update',
        'attr'   =>  array(
            'class'   => 'btn btn-primary btn-block text-uppercase')   
        )
    );

    
    
    $form->handleRequest($request);
    if ($form->isSubmitted()) {
        if($repa->getlibProd() == null)
        $repa->setlibProd($clone->getlibProd());

        if($repa->getDescription() == null)
        $repa->setDescription($clone->getDescription());

        if($repa->getPrixProd() == null || is_numeric(!$repa->getPrixProd()))
        $repa->setPrixProd($clone->getPrixProd());

        if($repa->getQuantiteDispo() == null || is_numeric(!$repa->getQuantiteDispo()))
        $repa->setQuantiteDispo($clone->getQuantiteDispo());

        if($repa->getPath() == null)
        $repa->setPath($clone->getPath());
        

        $em = $this->getDoctrine()->getManager();
        $em->flush($repa);
        $this->addFlash(
            'repa_update',
            'Repa updated'
           );
        return $this->redirectToRoute('repa');
    }

    return $this->render('admin/editRepa.html.twig',array('form' => $form->createView()));
}

/**
 * @Route("/deleteRepa/{id}", name="deleteRepa")
 */
public function deleteRepa($id){
    $filesystem = new Filesystem();
    $repa = $this->getDoctrine()->getRepository(Repa::class)->find($id);
    $em = $this->getDoctrine()->getManager();
    $em->remove($repa);
    $em->flush();
   $lib = implode((array) $repa->getLibProd());

    $filesystem->remove(["FrontOffice/images/Repas/$lib.png"]);
    $this->addFlash(
        'repa_delete',
        'Repa deleted'
       );
    return $this->redirectToRoute("repa");
}
}
