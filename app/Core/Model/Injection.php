<?php

namespace Core\Model;

use Core\Abstracts\AbstractEvents;

class Injection
{
    public function __construct($container)
    {
        $container['notFoundHandler'] = function ($container) {
            return function ($request, $response) use ($container) {
                $template = '';
                $v = $container->view;
                $event = new AbstractEvents();
                $event->template = 'template::404';
                $container->get('events')->callback('before_notFound_load', $event);
                if (!empty($event->template)) {
                    $response->getBody()->write($v->render($event->template, ['title' => '404 Page Not Found']));
                    return $response->withStatus(404);
                }
                return $container['response']
                    ->withStatus(404)
                    ->withHeader('Content-Type', 'text/html')
                    ->write('Custom 404 Page not found');
            };
        };
    }
}
