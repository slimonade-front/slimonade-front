<?php

namespace Main\Controller;

use Core\Abstracts\AbstractRoute;
use Main\Controller\RouteAbstract;

class Routes extends AbstractRoute
{
    public function __construct()
    {
        $this->app->get('/', 'Main\Controller\RouteAbstract:home')
            ->setName('main_index');
        $this->app->get('/√[/]', 'Main\Controller\RouteAbstract:home')
            ->setName('main_index_√');
        $this->app->get('/cookie-policy[/]', 'Main\Controller\RouteAbstract:cookiePolicy')
            ->setName('main_cookie_policy');

        $this->app->get('/speed-test[/]', 'Main\Controller\RouteAbstract:speedTest')
            ->setName('speed_test');

    }
}
