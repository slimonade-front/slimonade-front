<?php

namespace Main\Model;

use Slim\Routing\RouteContext;

class Middleware
{
    public function __construct(&$app)
    {
        $c = $app->getContainer();
        $app->add(function ($request, $handler) use (&$c, $app) {
            try {
                if (strpos($c->get('routeName') ?? '', 'main_') !== false) {
                    $routeContext = RouteContext::fromRequest($request);
                    $c->set('router', $routeContext->getRouteParser());

                    $v = $c->get('view');
                    $m = $c->get('module');
                    $layoutFile = $m->getViewPath('Main');
                    // Load view path
                    // echo $layoutFile;exit;
                    // var_dump($v->exists('common'));die;
                    $v->addFolder('content', $layoutFile, true);
                    $v->addFolder('common', $layoutFile . 'page', true);
                    // echo $layoutFile;exit;
                }
                $response = $handler->handle($request);
                $existingContent = (string) $response->getBody();

                $response = $app->getResponseFactory()->createResponse();
                $response->getBody()->write($existingContent);

                return $response;
            } catch (\Exception $e) {
                $logger = $c->get('log');
                $logger->log($e->getCode(), $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
                $response = $handler->handle($request);
                $existingContent = (string) $response->getBody();

                $response = $app->getResponseFactory()->createResponse();
                $response->getBody()->write($existingContent);

                return $response;
            }
        });
    }
}
