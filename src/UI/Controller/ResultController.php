<?php

namespace App\UI\Controller;

use App\Application\Query\GetCode\CodeView;
use App\Application\Query\GetCode\GetCodeQuery;
use App\Application\Query\GetOpinions\GetOpinionsQuery;
use App\Application\Query\GetResult\GetResultQuery;
use App\Application\Query\GetResult\ResultView;
use App\Application\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class ResultController extends AbstractController
{
    #[Route('/{_locale<%app.supported_locales%>}/result/{resultUuid}', name: 'result', methods: ['GET'])]
    public function result(
        Request $request,
        QueryBus $queryBus,
        SessionInterface $session
    ): Response {
        try {
            $uuid = Uuid::fromString($request->get('resultUuid'));

            /** @var ResultView $view */
            $view = $queryBus->handle(new GetResultQuery($uuid));
        } catch (\Throwable $throwable) {
            return $this->redirectToRoute('app');
        }

        if ($session->has('code')) {
            /** @var CodeView $codeView */
            $codeView = $queryBus->handle(new GetCodeQuery($session->get('code')));
        } else {
            $codeView = null;
        }

        $opinions = $queryBus->handle(
            new GetOpinionsQuery(
                $uuid
            )
        );

        return $this->render('app/result.html.twig',
            [
                'view' => $view->jsonSerialize(),
                'codeView' => $codeView?->jsonSerialize(),
                'opinions' => $opinions->jsonSerialize(),
            ]
        );
    }
}
