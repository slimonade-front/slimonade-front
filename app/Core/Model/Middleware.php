<?php

namespace Core\Model;

use Slim\Routing\RouteContext;
use Core\Model\MyCustomErrorRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class Middleware
{
    public function __construct(\Slim\App &$app)
    {
        // Core\Model\MyCustomErrorRenderer
        // Add Error Middleware

        // $errorMiddleware = $app->addErrorMiddleware(true, true, true);

        // Get the default error handler and register my custom error renderer.
        // $errorHandler = $errorMiddleware->getDefaultErrorHandler();
        // $errorHandler->registerErrorRenderer('text/html', MyCustomErrorRenderer::class);

        // add below line in core Middleware because it is template layout structure folder that is used by many modules
        $c = $app->getContainer();

        // Define custom 404 error handler
// $customErrorHandler = function (
//     \Psr\Http\Message\ServerRequestInterface $request,
//     \Throwable $exception,
//     bool $displayErrorDetails,
//     bool $logErrors,
//     bool $logErrorDetails
// ) use ($app) {
    $response = $app->getResponseFactory()->createResponse();
//     $response->getBody()->write('Oops! Page not found.');
//     return $response->withStatus(404);
// };

// // Add error middleware
// $errorMiddleware = $app->addErrorMiddleware(true, true, true);
// $errorMiddleware->setErrorHandler('404', $customErrorHandler);

        $app->add(function (Request $request, RequestHandler $handler) use (&$c) {
            /** @var \Selective\Container\Container $c */
            $routeContext = RouteContext::fromRequest($request);
            $c->set('router', $routeContext->getRouteParser());
            try {
                // get current route name
                if ($route = $routeContext->getRoute()) {
                    $c->set('routeName', $route->getName());
                    if ($route->getName() === 'core_assets') {
                        $response = $handler->handle($request);

                        return $response->withHeader('Content-Type', $c->get('factory')->get('file_type'))
                            ->withHeader('Powered-By', 'Slimonade-Front');
                        // ->withHeader('ETag', $c->get('factory')->get('ETag'));
                    }
                    $m = $c->get('module');
                    $coreFile = $m->getViewPath('Core');
                    // Load layout files
                    // echo $coreFile . 'templates/';exit;
                    // added template in Core module as Default Template of all layouts
                    $c->get('view')->addFolder('template', $coreFile . 'templates/', true);
                } else {
                    $c->set('routeName', 404); // Page Not Pound
                    // moved page/ files to core and use event to change content from modules
                    // echo get_class($c);exit;
                    $m = $c->get('module');
                    $coreFile = $m->getViewPath('Core');
                    // Load layout files
                    // added template in Core module as Default Template of all layouts
                    $c->get('view')->addFolder('template', $coreFile . 'templates/', true);
                    $c->get('view')->addFolder('common', $coreFile . 'page/', true);

                    // $layoutFile = $m->getViewPath('Shorturl');

                    $c->get('view')->addFolder('content', $coreFile . 'templates/');
                }
                // return $next($request, $response);
                $response = $handler->handle($request);
                $response->getBody();
                // echo $c->get('ETag');exit;
                return $response;
            } catch (\Exception $e) {
                $logger = $c->get('log');
                $logger->log($e->getCode(), $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
                // return $next($request, $response);
                $response = $handler->handle($request);
                $response->getBody();
                return $response;
            }
        });
    }
}
