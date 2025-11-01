<?php

namespace Main\Controller;

use Core\Abstracts\AbstractEvents;
use Selective\Container\Container;
use Psr\Http\Message\ServerRequestInterface as ServerRequest;

class RouteAbstract
{
    private $container;

    // constructor receives container instance
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param $request \Psr\Http\Message\ServerRequestInterface
     * @param $response \Psr\Http\Message\ResponseInterface
     * @param $args
     */
    public function home(ServerRequest $request, $response, $args)
    {
        $e = $this->container->get('events');
        $v = $this->container->get('view');
        // $m = $this->container->get('module');

        // $layoutFile = $m->getViewPath('Slimonade Front');
        $events = new AbstractEvents();
        $events->template = 'content::homepage';
        $e->callback('before_homepage_load', $events);
        // echo $events->template;exit;
        $response->getBody()->write($v->render($events->template, ['title' => 'Welcome to Slimonade Front']));
        if (isset($request->getQueryParams()['clearcache'])) {
            unlink(ROOT . '\cache\routecache');
        }
        return $response->withStatus(200);
    }

    public function cookiePolicy($request, $response, $args)
    {
        $e = $this->container->get('events');
        $v = $this->container->get('view');
        $m = $this->container->get('module');

        $layoutFile = $m->getViewPath('Slimonade Front');
        $events = new AbstractEvents();
        $events->template = 'content::cookie_policy';
        $e->callback('before_homepage_load', $events);
        $response->getBody()->write($v->render($events->template, ['title' => 'Cookie Policy']));
        if (isset($request->getQueryParams()['clearcache'])) {
            unlink(ROOT . '\cache\routecache');
        }
        return $response->withStatus(200);
    }

    public function speedTest($request, $response, $args)
    {
        $response->getBody()->write('Speed test page <span id="time"></span> seconds<script>var n = performance.now() / 1000;n=n.toFixed(4);document.querySelector(\'#time\').innerText=n;</script>');
        return $response->withStatus(200);
    }
}
