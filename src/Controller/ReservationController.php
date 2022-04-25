<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Dompdf\Dompdf;
use Dompdf\Options;
use \Twilio\Rest\Client;


/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    private $twilio;

    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }
    /**
     * @Route("/reservationinfo", name="reservation_info", methods={"GET"})
     */
    public function reservationinfo(EntityManagerInterface $entityManager): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reservation/reservationinfo.html.twig', [
            'reservations' => $reservations,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("ReservationList.pdf", [
            "Attachment" => true
        ]);

        return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);

    }
    /**
     * @Route("/", name="reservation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/reservationBack", name="reservation_Back", methods={"GET"})
     */
    public function indexBack(EntityManagerInterface $entityManager, Request $request,PaginatorInterface $paginator): Response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();

            $respagination = $paginator->paginate(
            $reservations, // on passe les donnees
            $request->query->getInt('page', 1),// Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5
        );

        return $this->render('reservation/reservationBack.html.twig', [
            'reservations' => $respagination,

        ]);
    }

    /**
     * @Route("/reservationBack/d", name="reservation_Back_d", methods={"GET"})
     */
    public function indexBackD(EntityManagerInterface $entityManager, Request $request,PaginatorInterface $paginator): Response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findBy([],["date" => "asc"]);

        $respagination = $paginator->paginate(
            $reservations, // on passe les donnees
            $request->query->getInt('page', 1),// Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5
        );

        return $this->render('reservation/reservationBack.html.twig', [
            'reservations' => $respagination,

        ]);
    }

    /**
     * @Route("/new", name="reservation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();
            $flashy->success('Reservation Ajouté', 'http://your-awesome-link.com');
            $message = $this->twilio->messages->create(
                '+21627086945', // Send text to this number
                array(
                    'from' => '+19124614145', // My Twilio phone number
                    'body' => 'Vous etes le bienvenue:'.$reservation->getNomclient().' '.$reservation->getNbpersonne()
                ));
            return $this->redirectToRoute('liste_reservation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {

        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('liste_reservation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="reservation_delete",methods={"GET", "POST"})
     */
    public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $res = $this->getDoctrine()->getRepository(Reservation::class)->find($id);

      //  var_dump($res);
            $entityManager->remove($res);
            $entityManager->flush();


        return $this->redirectToRoute('liste_reservation', [], Response::HTTP_SEE_OTHER);
    }

}
