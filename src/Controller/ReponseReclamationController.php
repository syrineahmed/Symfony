<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\ReponseReclamation;
use App\Form\ReponseReclamationType;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use function MongoDB\BSON\fromJSON;

use Symfony\Component\Mime\RawMessage;


#[Route('/reponse')]
class ReponseReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reponse_reclamation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, Request $request,PaginatorInterface $paginator): Response
    {
        $reponseReclamations = $entityManager
            ->getRepository(ReponseReclamation::class)
            ->findAll();
        $reponseReclamations= $paginator->paginate(
            $reponseReclamations,
            $request->query->getInt('page', 1), // page number
            5 // limit per page
        );

        return $this->render('reponse_reclamation/index.html.twig', [
            'reponse_reclamations' => $reponseReclamations,
        ]);
    }
    #[Route('/reclamation', name: 'app_reponce_reclamation_show', methods: ['GET'])]
    public function showReclamation(EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();


        return $this->render('reponse_reclamation/showReclamation.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

   #[Route('/{idRec}', name: 'app_reponse_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,Reclamation $reclamation): Response
    {
        $reponseReclamation = new ReponseReclamation();
        $reclamation->setEtat("traité");

        $reponseReclamation->setIdReclamation($reclamation);
        $form = $this->createForm(ReponseReclamationType::class, $reponseReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reponseReclamation);
            $entityManager->flush();
            $to=$reclamation->getEmail();
           // $content = '<p>See Twig integration for better HTML integration!</p>';
            $content = '<p> Voici les détails de votre réponse suite a votre reclamation  :</p>';
            $content .= '<p>' . $reponseReclamation->getSujet() . '</p>';
            $subject='MEDFLY!';
            $transport = Transport::fromDsn('gmail+smtp://syrine.ahmed@esprit.tn:223JFT4601@default?');

            // Create a Mailer instance with the specified transport
            $mailerWithTransport = new Mailer($transport);
            $email = (new Email())
                ->from('syrine.ahmed@esprit.tn')
                ->to($to)
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject($subject)
                // ->text('Sending emails is fun again!')
                ->html($content);


                $mailerWithTransport->send($email);


            // ...


            return $this->redirectToRoute('app_reponse_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_reclamation/new.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
            'form' => $form,
            'reclamation' => $reclamation,

        ]);
    }

    #[Route('/show/{idReponse}', name: 'app_reponse_reclamation_show', methods: ['GET'])]
    public function show(ReponseReclamation $reponseReclamation): Response
    {
        return $this->render('reponse_reclamation/show.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
        ]);
    }

    #[Route('/edit/{idReponse}', name: 'app_reponse_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReponseReclamation $reponseReclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponseReclamationType::class, $reponseReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse_reclamation/edit.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
            'form' => $form,
        ]);
    }

    #[Route('/show/{idReponse}', name: 'app_reponse_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, ReponseReclamation $reponseReclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponseReclamation->getIdReponse(), $request->request->get('_token'))) {
            $entityManager->remove($reponseReclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reponse_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/recherche/ff', name: 'reponse_recherche_2' )]
    public function searchAction1(Request  $request,EntityManagerInterface $em)
    {
        //  dd($request->query->all());
        $requestString = $request->query->get('k');

        $reponse_reclamations =  $em->getRepository(ReponseReclamation::class)->findEntitiesByStringReponse("$requestString");

        if(!count($reponse_reclamations)) {
            $result['reponse_reclamations']['error'] = $reponse_reclamation=null;
        } else {
            $result['reponse_reclamations'] = $this->getRealEntities($reponse_reclamations);
        }

        return new Response(json_encode($result));
    }
    public function getRealEntities($reponse_reclamations){
        foreach ($reponse_reclamations as $reponse){
            $formattedDate = $reponse->getDate()->format('Y-m-d');
            $realEntities[$reponse->getIdReponse()] = [$reponse->getSujet(),$reponse->getEtat(),$formattedDate,$reponse->getIdReponse()];

        }
        return $realEntities;
    }

}
