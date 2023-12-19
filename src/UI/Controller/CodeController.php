<?php

namespace App\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

final class CodeController extends AbstractController
{
    #[Route('/{_locale<%app.supported_locales%>}/code', name: 'code', methods: ['GET'])]
    public function code(): Response
    {
        // todo currentCode - reset / stats

        return $this->render('app/code.html.twig');
    }

    #[Route('/{_locale<%app.supported_locales%>}/set-code', name: 'set_code', methods: ['POST'])]
    public function setCode(SessionInterface $session, Request $request, RouterInterface $router): Response
    {
        $code = $request->get('code');
        $session->set('code', $code);

        return new JsonResponse(
            [
                'resultUrl' => $router->generate('app'),
            ]
        );
    }
}
