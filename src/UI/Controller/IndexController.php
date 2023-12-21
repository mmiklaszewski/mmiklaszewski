<?php

namespace App\UI\Controller;

use App\Application\Command\CommandBus;
use App\Application\Command\DownloadCV\DownloadCVCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    #[Route('/')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('homepage', ['_locale' => 'pl']);
    }

    #[Route('/{_locale<%app.supported_locales%>}/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('about_me/index.html.twig');
    }

    #[Route('/download-cv', name: 'download_cv')]
    public function downloadCV(Request $request, CommandBus $commandBus): Response
    {
        $file = new File('data/cv_maciej_miklaszewski.pdf');

        $commandBus->handle(
            new DownloadCVCommand(
                [
                    'headers' => $request->headers->all(),
                    'ip' => $request->headers->get('X-Forwarded-For') ?? $request->getClientIp(),
                ]
            )
        );

        $response = new Response(file_get_contents($file->getRealPath()));
        $response->setStatusCode(200);
        $response->headers->set('Content-Length', $file->getSize() ?? 0);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set(
            'Content-Disposition',
            sprintf('attachment; filename="%s"', $file->getFilename())
        );

        return $response;
    }
}
