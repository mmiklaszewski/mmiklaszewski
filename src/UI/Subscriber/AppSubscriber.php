<?php

namespace App\UI\Subscriber;

use App\UI\Controller\AppController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

final class AppSubscriber implements EventSubscriberInterface
{
    public function __construct(private RequestStack $requestStack, private RouterInterface $router)
    {
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        // when a controller class defines multiple action methods, the controller
        // is returned as [$controllerInstance, 'methodName']
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof AppController) {
            $code = $this->requestStack->getSession()->get('code', null);

            // todo limit użyć lub null

            if (null === $code) {
                $response = new RedirectResponse($this->router->generate('code'), 302);
                $response->send();
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
