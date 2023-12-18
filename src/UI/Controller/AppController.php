<?php

namespace App\UI\Controller;

use App\Application\Command\CollectDataAboutMovie\CollectDataAboutMovieCommand;
use App\Application\Command\CommandBus;
use App\Application\Query\GetResult\GetResultQuery;
use App\Application\Query\QueryBus;
use App\UI\Input\GenerateResponseAboutMovieInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Uid\Uuid;

final class AppController extends AbstractController
{
    #[Route('/{_locale<%app.supported_locales%>}/app', name: 'app', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('app/generate_response.html.twig');
    }

    #[Route('/{_locale<%app.supported_locales%>}/app/generate-response', name: 'generate-response', methods: ['POST'])]
    public function generateResponse(
        #[MapRequestPayload] GenerateResponseAboutMovieInput $input,
        CommandBus $commandBus,
        RouterInterface $router
    ): JsonResponse {

        return new JsonResponse(
            [
                'resultUrl' => $router->generate('result', ['resultUuid' => Uuid::fromString('a76bde64-ab77-4905-b124-8d1658d7f30a')]),
            ]
        );

        try {
            $uuid = Uuid::v4();
            $commandBus->handle(
                CollectDataAboutMovieCommand::fromInput($uuid, $input)
            );

            return new JsonResponse(
                [
                    'resultUrl' => $router->generate('result', ['resultUuid' => $uuid->jsonSerialize()]),
                ]
            );
        } catch (\Throwable $throwable) {
            return new JsonResponse(sprintf('Exception: %s', $throwable->getMessage()));
        }
    }

    #[Route('/{_locale<%app.supported_locales%>}/result/{resultUuid}', name: 'result', methods: ['GET'])]
    public function result(
        Request $request,
        QueryBus $queryBus
    ): Response {
        try {
            $uuid = Uuid::fromString($request->get('resultUuid'));

            $view = $queryBus->handle(new GetResultQuery($uuid));
        } catch (\Throwable $throwable) {
            return $this->redirectToRoute('app');
        }

        return $this->render('app/result.html.twig',
            [
                'view' => $view->jsonSerialize(),
            ]
        );
    }
}
