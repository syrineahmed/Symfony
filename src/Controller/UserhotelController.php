<?php

namespace App\Controller;

use App\Entity\Hotels;
use App\Entity\Userhotel;
use App\Form\UserhotelType;
use App\Repository\HotelsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;


#[Route('/userhotel')]
class UserhotelController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_userhotel_index', methods: ['GET'])]
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $hotelsRepository = $entityManager->getRepository(Hotels::class);
        $hotels = $hotelsRepository->findAll();

        return $this->render('userhotel/index.html.twig', [
            'hotels' => $hotels,
        ]);
    }

    #[Route('/reserve/{idHotel}', name: 'app_userhotel_reserve', methods: ['GET', 'POST'])]
    public function reserve(Request $request, EntityManagerInterface $entityManager, HotelsRepository $hotelsRepository, int $idHotel): Response
    {
        // Retrieve the selected hotel
        $hotel = $hotelsRepository->find($idHotel);

        // Check if the hotel exists
        if (!$hotel) {
            throw $this->createNotFoundException('Hotel not found');
        }

        // Create a new instance of Userhotel and automatically fill in some information
        $userhotel = new Userhotel();
        $userhotel->setNomHotel($hotel->getNomHotel());
        $userhotel->setPays($hotel->getPays());

        // Create the form
        $form = $this->createForm(UserhotelType::class, $userhotel);

        // Process the form when it is submitted
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Retrieve the number of reserved rooms
            $nbChambresReservees = $form->get('chambreReservee')->getData();

            // Check if the number of reserved rooms is available
            $nbChambresDisponibles = $hotel->getNbChambre();

            if ($nbChambresReservees > $nbChambresDisponibles) {
                // If the number of reserved rooms is greater than available rooms
                $this->addFlash('danger', 'Il n\'y a pas suffisamment de chambres disponibles. Il reste seulement ' . $nbChambresDisponibles . ' chambre(s).');
                return $this->redirectToRoute('app_userhotel_reserve', ['idHotel' => $idHotel]);
            }

            // Remaining processing for the reservation
            $entityManager->persist($userhotel);
            $prixNuit = $hotel->getPrixNuit();
            $nbNuits = $form->get('nbNuits')->getData();
            $facture = $nbNuits * $nbChambresReservees * $prixNuit;

            $userhotel->setFactureHotel($facture);
            $hotel->setNbChambre($nbChambresDisponibles - $nbChambresReservees);

            $entityManager->flush();
            $this->sendTwilioMessage($userhotel);

            return $this->redirectToRoute('app_pdf');
        }

        // Display the form
        return $this->render('userhotel/reserve.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_userhotel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userhotel = new Userhotel();
        $form = $this->createForm(UserhotelType::class, $userhotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($userhotel);
            $entityManager->flush();

            return $this->redirectToRoute('app_userhotel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('userhotel/new.html.twig', [
            'userhotel' => $userhotel,
            'form' => $form,
        ]);
    }

    #[Route('/{numpassport}', name: 'app_userhotel_show', methods: ['GET'])]
    public function show(Userhotel $userhotel): Response
    {
        return $this->render('userhotel/show.html.twig', [
            'userhotel' => $userhotel,
        ]);
    }

    #[Route('/{numpassport}', name: 'app_userhotel_delete', methods: ['POST'])]
    public function delete(Request $request, Userhotel $userhotel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userhotel->getNumpassport(), $request->request->get('_token'))) {
            $entityManager->remove($userhotel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_userhotel_index', [], Response::HTTP_SEE_OTHER);
    }

    private function sendTwilioMessage(Userhotel $userhotel): void
    {
        $twilioAccountSid = $this->getParameter('twilio_account_sid');
        $twilioAuthToken = $this->getParameter('twilio_auth_token');
        $twilioPhoneNumber = $this->getParameter('twilio_phone_number');

        $twilioClient = new Client($twilioAccountSid, $twilioAuthToken);

        // Replace 'to' with the recipient phone number
        // Replace 'from' with your Twilio phone number
        $twilioClient->messages->create(
            '+21693728865', // Replace with the recipient's phone number
            [
                'from' => $twilioPhoneNumber,
                'body' => 'Reservation avec succées mr ' . $userhotel->getUserPrenom(),
            ]
        );
    }
}
