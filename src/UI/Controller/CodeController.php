<?php

namespace App\UI\Controller;

use App\Application\Query\GetCode\CodeView;
use App\Application\Query\GetCode\GetCodeQuery;
use App\Application\Query\QueryBus;
use App\Domain\Exception\CodeNotFound;
use App\Domain\Exception\CodeWasUsed;
use App\Domain\Specification\CanUseCode;
use App\UI\Input\SetCodeInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class CodeController extends AbstractController
{
    #[Route('/{_locale<%app.supported_locales%>}/code', name: 'code', methods: ['GET'])]
    public function code(SessionInterface $session, QueryBus $queryBus): Response
    {
        if ($session->has('code')) {
            /** @var CodeView $codeView */
            $codeView = $queryBus->handle(new GetCodeQuery($session->get('code')));
        }

        return $this->render('app/code.html.twig', [
            'codeView' => $codeView ?? null,
        ]);
    }

    #[Route('/{_locale<%app.supported_locales%>}/set-code', name: 'set_code', methods: ['POST'])]
    public function setCode(
        SessionInterface $session,
        #[MapRequestPayload] SetCodeInput $input,
        RouterInterface $router,
        CanUseCode $canUseCode,
        TranslatorInterface $translator
    ): Response {
        try {
            $canUseCode->isSatisfiedBy($input->code);
        } catch (CodeNotFound $exception) {
            return new JsonResponse(
                [
                    'errors' => [
                        'code_not_found' => $translator->trans('errors.not_found', ['%code%' => $input->code], 'code'),
                    ],
                ]
            );
        } catch (CodeWasUsed $exception) {
            return new JsonResponse(
                [
                    'errors' => [
                        'code_used' => $translator->trans('errors.code_is_used', ['%code%' => $input->code], 'code'),
                    ],
                ]
            );
        }

        $session->set('code', $input->code);

        return new JsonResponse(
            [
                'resultUrl' => $router->generate('app'),
            ]
        );
    }
}
