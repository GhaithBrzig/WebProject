<?php

namespace App\Controller;

use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeReservationController extends AbstractController
{
    /**
     * @Route("/liste/reservation", name="liste_reservation")
     */
    public function liste_reservation()
    {
        $reservation = $this->getDoctrine()->getRepository(Reservation::class)->findAll();

        return $this->render('reservation/show.html.twig',array( "reservations" => $reservation));

    }
}
