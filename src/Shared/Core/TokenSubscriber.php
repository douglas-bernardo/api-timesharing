<?php


namespace App\Shared\Core;

use App\Shared\Bundle\Controller\TokenAuthenticatedController;
use Exception;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class TokenSubscriber implements EventSubscriberInterface
{
    private string $token;

    public function onKernelController(ControllerEvent $event)
    {

            $controller = $event->getController();

            if (is_array($controller)) {
                $controller = $controller[0];
            }

            if ($controller instanceof TokenAuthenticatedController) {
                $request = $event->getRequest();

                $authHeader = $request->headers->get('authorization');

                if (!$authHeader) {
                    throw new AccessDeniedHttpException('This action needs a valid token!');
                }

            }

            // $requestToken = explode(' ', $authHeader);

            // $config = getConfigJWT();


//            $token = $config->parser()->parse($requestToken[1]);
//
//            $config->setValidationConstraints(
//                new IssuedBy('http://app.renegociacao'),
//                new SignedWith(new Sha256(), InMemory::plainText($_ENV['JWT_SECRET'])),
//                new LooseValidAt(SystemClock::fromUTC())
//            );
//
//            $constraints = $config->validationConstraints();
//
//            $config->validator()->assert($token, ...$constraints);
//
//            $request->attributes->add([
//                'user' => [
//                    'ts_usuario_id' => $token->headers()->get('ts_usuario_id'),
//                    'uid' => $token->headers()->get('uid')
//                ]
//            ]);
            // $request->attributes->add(['test' => 'auth']);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }
}