<?php

namespace Core\Controller;

use Core\Abstracts\AbstractRoute;
use Core\Controller\RouteAbstract;

class Routes extends AbstractRoute
{
    public function __construct()
    {
        // $this->app->get('/assets/{params:.*js|.*css}', '\Core\Controller\RouteAbstract:assets')->setName('core_assets');
        $this->app->get('/♪' . rawurlencode('♪'), '\Core\Controller\RouteAbstract:music')->setName('core_assets');
    }
}
