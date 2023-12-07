<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Utilisateur;
use App\Exception\InvalidEmailException;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Repository\UtilisateurRepository;
use App\Service\TwilioService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

#[Route('/reclamation')]

class ReclamationController extends AbstractController
{

    #[Route('/', name: 'app_reclamation_index', methods: ['GET', 'POST'])]
    public function index(ReclamationRepository $reclamationRepository, Request $request,PaginatorInterface $paginator): Response
    {
        $etat = $request->get('etat', 'all');

        $reclamations = [];

        if ($etat === 'traité') {
            $reclamations = $reclamationRepository->findBy(['etat' => 'traité']);
        } elseif ($etat === 'non traité') {
            $reclamations = $reclamationRepository->findBy(['etat' => 'non traité']);
        } else {
            $reclamations = $reclamationRepository->findAll();
        }
        //composer require knplabs/knp-paginator-bundle
       // $queryBuilder = $reclamationRepository->createQueryBuilder('r');

        $reclamations= $paginator->paginate(
            $reclamations,
            $request->query->getInt('page', 1), // page number
            10 // limit per page
        );
        // dd($etat);

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
            'etat' => $etat,
        ]);
    }


    /////////////client/////////////////////////

    //////////////////stat////////////////////////
    #[Route('/test', name: 'app_reclamation_index1', methods: ['GET'])]
    public function index2(ReclamationRepository $reclamationRepository): Response
    {
        $reclamationsCount = $reclamationRepository->countReclamations();
        $countNonTraiteReclamations = $reclamationRepository->countNonTraiteReclamations();
        $countTraiteReclamations = $reclamationRepository->countTraiteReclamations();
        $percentageNonTraite = ($countNonTraiteReclamations / $reclamationsCount) * 100;
        $percentageTraite = ($countTraiteReclamations / $reclamationsCount) * 100;

        return $this->render('reclamation/accueil.html.twig', [
            'reclamationsCount' => $reclamationsCount,
            'countNonTraiteReclamations' => $countNonTraiteReclamations,
            'countTraiteReclamations' => $countTraiteReclamations,
            'percentageNonTraite' => $percentageNonTraite,
            'percentageTraite' => $percentageTraite,

        ]);
    }
    /////////////ajouter/////////////////////////

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,UtilisateurRepository $utilisateurRepository,TwilioService $twilioService ): Response
    {
       // dd($request);
        $reclamation = new Reclamation();
        $user=$utilisateurRepository->find(1);
        $reclamation->setIdUtilisateur($user);

        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($reclamation->containsInappropriateWords()) {
                // Handle inappropriate words, for example, add a form error
                $form->get('description')->addError(new FormError('Inappropriate words found in the description.'));
            } else {

                try {
                    if ($form->isValid()) {
                        // Your other logic
                        $entityManager->persist($reclamation);
                        $entityManager->flush();
                        $to="+21654099718";
                        $body="MEDFLY : VOTRE RECLAMATION ESR AJOUTEE AVEC SUCEES ";
                        $twilioService->sendSms($to,$body);
                        $this->addFlash('success', 'Your reclamation has been added successfully.');


                        return $this->render('Client/client.html.twig'
                        );
                    }
                } catch (InvalidEmailException $exception) {
                    // Handle the exception, for example, set a custom error message
                    $form->get('email')->addError(new FormError('Invalid email. Please enter a valid email address.'));
                }
            }

        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    //////////////////////////////////////////

    #[Route('/show/{idRec}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {

        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/edit/rec/{idRec}', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{idRec}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdRec(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/remove/{idRec}', name: 'app_reclamation_delete2', methods: ['GET','POST'])]
    public function delete2($idRec, ReclamationRepository $reclamationRepository , EntityManagerInterface $entityManager): Response
    {

            $rec = $reclamationRepository->find($idRec);
            $entityManager->remove($rec);
            $entityManager->flush();


        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
    ///////RECHERCHE/////
    #[Route('/search', name: 'reclamation_search' )]
    public function searchAction(Request $request,EntityManagerInterface $em)
    {
      //  dd($request->query->all());
        $requestString = $request->query->get('q');

        $reclamations =  $em->getRepository(Reclamation::class)->findEntitiesByString("$requestString");

        if(!count($reclamations)) {
            $result['reclmations']['error'] = "Aucune reclamation trouvée  ";
        } else {
            $result['reclamations'] = $this->getRealEntities($reclamations);
        }

        return new Response(json_encode($result));
    }
    /////lire les valeurs dans le js
    public function getRealEntities($reclamations){
        foreach ($reclamations as $reclamation){
            $formattedDate = $reclamation->getDate()->format('Y-m-d');
            $realEntities[$reclamation->getIdRec()] = [$reclamation->getSujet(),$reclamation->getEmail(),$reclamation->getDescription(),$reclamation->getEtat(),$formattedDate,$reclamation->getIdRec()];

        }
        return $realEntities;
    }





}
