<?php

namespace App\Controller;

use App\Entity\GestionCategories;

use App\Form\SearchType;
use App\Form\ServiceType;
use App\Model\SearchData;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//#[Route('/service')]
class ServiceController extends AbstractController
{
    #[Route('/am', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'message' => 'Bienvenue sur mon application Symfony !',
        ]);
    }
    #[Route('/ajouttyy', name: 'new_service')]
    public function Ajouter(ManagerRegistry $doctrine,Request $request):Response
    {
        $service= new GestionCategories();
        $form=$this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $em= $doctrine->getManager();

            $em->persist($service);
            $em->flush();
           /* $html = $this->render('contenue_twig/PdfDef.html.twig');
            $pdf->showPdfFile($html);*/
        }
        return $this->render('contenue_twig/addservice.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/modifyyy/{id}', name: 'edit_service')]
    public function edit(Request $request, ManagerRegistry $manager, $id, CategorieRepository $serviceRepository):Response{
        $em = $manager->getManager();
        $service  = $serviceRepository->find($id);
        $form=$this->createForm(ServiceType::class,$service);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            $em->persist($service);
            $em->flush();
            return $this->redirectToRoute('new_service');
        }
        return $this->renderForm('contenue_twig/EditService.html.twig', [
            'author' => $service,
            'form' => $form,
        ]);
    }
   /* #[Route('/servic', name: 'service_db')]
    public function read(ServiceRepository $serviceRepository){

        return $this->render('contenue_twig/list_service.html.twig', [
            'services' => $serviceRepository->findAll()

        ]);

    }*/
    #[Route('/servicc', name: 'service_db')]
    public function read(CategorieRepository $serviceRepository,PaginatorInterface $paginator,Request $request){

        $searchData= new SearchData();
        $formm=$this->createForm(SearchType::class, $searchData);
        $formm->handleRequest($request);

          if ($formm->isSubmitted()&& $formm->isValid()){
            $searchData->page=$request->query->getInt('page',1);
            $posts=$serviceRepository->findBySearch($searchData);
            return $this->render('contenue_twig/list_service.html.twig',[
                'formm'=>$formm->createView(),
                'posts'=>$posts
            ]);
        }

        $data=$serviceRepository->findAll();
        $service=$paginator->paginate(
        $data,$request->query->getInt('page',1),3
        );

        return $this->render('contenue_twig/list_service.html.twig', [
            'form' => $formm->createView(),
            'services' => $service,



        ]);

    }
    /*#[Route('/pdf', name: 'service_pdf')]
    public function generatePdfService( PdfService $pdf) {
        $html = $this->render('contenue_twig/PdfDef.html.twig');
        $pdf->showPdfFile($html);
    }*/
   /* #[Route('/servic', name: 'service_db')]
    public function read(ServiceRepository $serviceRepository,PaginatorInterface $paginator,Request $request){

        $searchData= new SearchData();
        $formm=$this->createForm(SearchType::class, $searchData);
        $formm->handleRequest($request);
        $data=$serviceRepository->findAll();
        $service=$paginator->paginate(
            $data,$request->query->getInt('page',1),8
        );
        if ($formm->isSubmitted()&& $formm->isValid()) {
            $searchData->page = $request->query->getInt('page', 1);
            $posts = $serviceRepository->findBySearch($searchData);

            return $this->render('contenue_twig/list_service.html.twig', [
                'formm' => $formm->createView(),
                'posts' => $posts,
                'services' => $service
            ]);
        }

        return $this->redirectToRoute('service_db');
    }*/
    #[Route('/delett/{id}', name: 'delete_service')]
    public function delete(Request $request, ManagerRegistry $manager, $id, CategorieRepository $serviceRepository):RedirectResponse{
        $em = $manager->getManager();
        $service  = $serviceRepository->find($id);
        $em->remove($service);
        $em->flush();
        return $this->redirectToRoute('service_db');
    }
    #[Route('/cherchh', name: 'cherch_service')]
    public function chercher(Request $request, ManagerRegistry $manager, CategorieRepository $serviceRepository): Response
    {
        $searchTerm = $request->query->get('search');

        // Vérifier si $searchTerm est un entier (ID)
$service=null;
        if (ctype_digit($searchTerm)) {
            // Convertir la chaîne en entier
            $searchId = (int)$searchTerm;
            $service = $serviceRepository->find($searchId);

        }
        return $this->render('contenue_twig/show_service.html.twig',[
            'service'=>$service,
        ]);
    }


}