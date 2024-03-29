<?php

use App\Shared\Core\TokenSubscriber;
use App\Shared\Core\Framework;
use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;

$containerBuilder = new DependencyInjection\ContainerBuilder();

$containerBuilder->register('context', Routing\RequestContext::class);

$containerBuilder->register('matcher', Routing\Matcher\UrlMatcher::class)
                 ->setArguments(['%routes%', new Reference('context')]);

$containerBuilder->register('request_stack', HttpFoundation\RequestStack::class);
$containerBuilder->register('controller_resolver', HttpKernel\Controller\ControllerResolver::class);
$containerBuilder->register('argument_resolver', HttpKernel\Controller\ArgumentResolver::class);

$containerBuilder->register('listener.router', HttpKernel\EventListener\RouterListener::class)
                ->setArguments([new Reference('matcher'), new Reference('request_stack')]);

$containerBuilder->register('listener.exception', HttpKernel\EventListener\ErrorListener::class)
                ->setArguments(['App\Shared\Bundle\Controller\ErrorController::exception']);

$containerBuilder->register('listener.auth', TokenSubscriber::class);

$containerBuilder->register('dispatcher', EventDispatcher\EventDispatcher::class)
                ->addMethodCall('addSubscriber', [new Reference('listener.router')])
                ->addMethodCall('addSubscriber', [new Reference('listener.exception')])
                ->addMethodCall('addSubscriber', [new Reference('listener.auth')]);

$containerBuilder->register('framework', Framework::class)
                ->setArguments([
                    new Reference('dispatcher'),
                    new Reference('controller_resolver'),
                    new Reference('request_stack'),
                    new Reference('argument_resolver')
                ]);

return $containerBuilder;