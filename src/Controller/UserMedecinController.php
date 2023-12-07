<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Medecin;
use App\Form\MedecinType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MedecinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class UserMedecinController extends AbstractController
{
    #[Route('/medecin', name: 'app_medecin')]
    public function index(): Response
    {
        return $this->render('medecin/index.html.twig', [
            'controller_name' => 'MedecinController',
        ]);
    }
    #[Route('/list_medecins', name: 'list_medecins')]
    public function listMedecins(MedecinRepository $repo): Response
    {
        $medecins = $repo->findAll(); // Change the method name and repository class
    
        return $this->render('medecin/list_Medecins.html.twig', [
            'medecins' => $medecins,
        ]);
    }
    #[Route('/add_usermedecin', name: 'add_usermedecin')]
public function adduserMedecin(ManagerRegistry $manager, Request $request): Response
{
    $em = $manager->getManager();

    $medecin = new Medecin();

    $form = $this->createForm(MedecinType::class, $medecin); // Assuming you have a MedecinType form class

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // You can perform additional actions here before persisting the medecin entity

        $em->persist($medecin);
        $em->flush();
        $this->sendTwilioMessage($medecin);

        return $this->redirectToRoute('app_login');
    }

    return $this->renderForm('medecin/add_UserMedecin.html.twig', [
        'form' => $form,
    ]);
}
private function sendTwilioMessage(Medecin $medecin): void
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
                'body' => 'This doctor has been added: ' . $medecin->getNom(),
            ]
        );
    }

}
