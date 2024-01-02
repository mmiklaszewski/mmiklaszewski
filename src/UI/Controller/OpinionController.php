<?php

namespace App\UI\Controller;

use App\Application\Command\CommandBus;
use App\Application\Command\SaveOpinion\SaveOpinionCommand;
use App\UI\Input\SaveOpinionInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

final class OpinionController extends AbstractController
{
    #[Route('/{_locale<%app.supported_locales%>}/app/save-opinion', name: 'save-opinion', methods: ['POST'])]
    public function saveOpinion(
        #[MapRequestPayload] SaveOpinionInput $input,
        RouterInterface $router,
        TranslatorInterface $translator,
        CommandBus $commandBus
    ): Response {
        try {
            $uuid = Uuid::v4();
            $commandBus->handle(
                SaveOpinionCommand::fromInput($uuid, $input)
            );
        } catch (\Throwable $throwable) {
            return new JsonResponse(
                [
                    'errors' => [
                        'code_used' => $translator->trans('errors.cant_save_opinion', [], 'app'),
                    ],
                ]
            );
        }

        return new JsonResponse(
            [
                'resultUrl' => $router->generate('result', ['resultUuid' => $input->movie->jsonSerialize()]),
            ]
        );
    }
}
