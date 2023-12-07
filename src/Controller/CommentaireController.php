<?php

namespace App\Controller;

use App\Repository\CommentaireRepository;
use Symfony\Component\Mailer\MailerInterface;
use App\Entity\Avisetcommentaires;
use App\Form\CommentaireType;
use App\Form\SearchType;
use App\Model\SearchData;
//use App\Service\PdfService;
use App\Service\SmsGenerator;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class CommentaireController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        return new Response('Accueil');
    }
   /* #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'message' => 'Bonjour mes étudiants',
        ]);
    }*/

    /* #[Route('/ajoutte', name: 'new_comm')]
     public function Ajoutte(ManagerRegistry $doctrine,Request $request,SmsGenerator $smsGenerator):Response
     {

         $commentaire= new Commentaire();
         $forme=$this->createForm(CommentaireType::class, $commentaire);
         $forme->handleRequest($request);
         //$number=$request->request->get('number');
         $amir=new Commentaire();
         $amir=$forme->getData();
        // $number=$amir->getIdPatient();
         $number = '+21695685049';
         $namee='MedFly  ';
         $text='Bonjour Mr.HJIRI Amir il ya un nouveau commentaire à été ajouter ';
        // $number_test=$_ENV['+13203851117'];
         if ($forme->isSubmitted()&& $forme->isValid()){
            // $rating = $request->request->get('rating');
             $rating = $commentaire->getNote();
             $emm= $doctrine->getManager();
             $emm->persist($commentaire);
             $emm->flush();
            // $smsGenerator->SendSms($number,$namee,$text);

         }

         return $this->render('contenue_front/add_comment.html.twig', [
             'smsSent'=>true,
             'forme' => $forme->createView(),
         ]);


     }*/
    #[Route('/ajouttee', name: 'new_commm')]
    public function Ajoutte(ManagerRegistry $doctrine,Request $request,SmsGenerator $smsGenerator):Response
    {

        $commentaire= new Avisetcommentaires();
        $forme=$this->createForm(CommentaireType::class, $commentaire);
        $forme->handleRequest($request);
        $number = '+21695685049';
        $namee='MedFly  ';
        $text='Bonjour Mr.HJIRI Amir il ya un nouveau commentaire à été ajouter ';
        if ($forme->isSubmitted()&& $forme->isValid()){
            $smsGenerator->SendSms($number,$namee,$text);
            //CGVX4J587FBN25ZPHGF9NCLT
            $emm= $doctrine->getManager();
            $emm->persist($commentaire);
            $emm->flush();
        }
        return $this->render('contenue_front/add_comment.html.twig', [
            'smsSent'=>true,
            'forme' => $forme->createView(),
        ]);
    }
    /*  #[Route('/pdf/{id}', name: 'personne.pdf')]
      public function generatePdfPersonne(Commentaire $commentaires = null, PdfService $pdf) {
          $html = $this->render('contenue-front/list-commentaire.html.twig', ['commentaires' => $commentaires]);
          $pdf->showPdfFile($html);
      }*/
    /* #[Route('/ajoutte', name: 'new_comm')]
     public function Ajoutte(ManagerRegistry $doctrine, Request $request,ValidatorInterface $validator): Response
     {
         $commentaire = new Commentaire();
         $forme = $this->createForm(CommentaireType::class, $commentaire);
         $forme->handleRequest($request);

         if ($forme->isSubmitted() && $forme->isValid()) {
             try {
                 $type=new CommentaireType();
                 //$type->validateComment($commentaire->getCommentair(), $type->get('validator'), $validator);
               //  $type->validateComment($commentaire->getCommentair(),);
                 // Si la validation réussit, persistez les données
                 $emm = $doctrine->getManager();
                 $emm->persist($commentaire);
                 $emm->flush();

                 // Redirection vers une autre page en cas de succès
                 return $this->redirectToRoute('comme_db');
             } catch (\Exception $e) {

                 return $this->redirectToRoute('comme_db');
             }
         }

         return $this->render('contenue_front/add_comment.html.twig', [
             'forme' => $forme->createView(),
         ]);
     }*/
    /* #[Route('/ajoutte', name: 'new_comm')]
     public function Ajoutte(ManagerRegistry $doctrine, Request $request, ValidatorInterface $validator,MailerInterface $mailer): Response
     {
         $commentaire = new Commentaire();
         $forme = $this->createForm(CommentaireType::class, $commentaire);
         $forme->handleRequest($request);

         if ($forme->isSubmitted() && $forme->isValid()) {
             try {
                 $errors = $validator->validate($commentaire);

                 if (count($errors) === 0) {
                     $email = (new Email())
                         ->from('amir.hjiri@esprit.tn')
                         ->to('hjiriamir2020@gmail.com')
                         ->subject('Welcome!')
                         //->attach('Hello World!', 'welcome.txt')
                         ->text('bonjour');
                     //->html($html);
                     $mailer->send($email);
                     $emm = $doctrine->getManager();
                     $emm->persist($commentaire);
                     $emm->flush();

                      Redirection en cas de succès
                     return $this->redirectToRoute('comme_db');
                 } else {
                     foreach ($errors as $error) {
                         $this->addFlash('error', $error->getMessage());
                     }


                     return $this->redirectToRoute('comme_db');
                 }
             } catch (\Exception $e) {
                // $too=$commentaire->getEmail();
                /$email = (new Email())
                     ->from('amir.hjiri@esprit.tn')
                     ->to('hjiriamir2020@gmail.com')
                     ->subject('Welcome!')
                     //->attach('Hello World!', 'welcome.txt')
                     ->text('bonjour');
                     //->html($html);
                 $mailer->send($email);
                 return $this->redirectToRoute('comme_db');
             }
         }
         return $this->render('contenue_front/add_comment.html.twig', [
             'forme' => $forme->createView(),
         ]);
     }*/
    #[Route('/comme', name: 'comme_db')]
    public function read(CommentaireRepository $commentaireRepository /*,PaginatorInterface $paginator*/,Request $request){

        $data=$commentaireRepository->findAll();
        /*$commentaires=$paginator->paginate(
            $data,$request->query->getInt('page',1),
            8
        );*/
        return $this->render('contenue_front/list_commentaire.html.twig'/*, [

            'commentaires' => $commentaires
        ]*/);

    }
}