<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse; // Importez cette classe
use App\Entity\Userhotel;
use App\Repository\UserHotelRepository;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf')]
    public function generatePdf(UserHotelRepository $userHotelRepository): Response
    {
        // Get the last user who made a reservation
        $lastUser = $userHotelRepository->findOneBy([], ['numpassport' => 'DESC']);

        // If no user found, you might want to handle this case or redirect to an error page
        /* if (!$lastUser) {
            // Handle the case where no user is found
            // ...

            // Redirect to an error page or homepage
            return $this->redirectToRoute('homepage');
        }*/

        // Configure Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isFontSubsettingEnabled', true);

        // Instantiate Dompdf
        $dompdf = new Dompdf($options);

        // Load HTML content from a Twig template
        $html = $this->renderView('pdf/index.html.twig', [
            'User' => $lastUser,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Set paper size (optional)
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (first pass to get total pages)
        $dompdf->render();

        // Output the generated PDF to a variable
        $output = $dompdf->output();

        // Return a Symfony Response with the PDF
        $response = new Response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="user_reservation.pdf"',
        ]);

        // Add a callback to execute after the response has been sent
        $response->headers->set('Content-Disposition', $response->headers->get('Content-Disposition') . '; post-action=redirect_homepage');

        return $response;
    }
}
