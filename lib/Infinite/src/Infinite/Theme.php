<?php

declare(strict_types=1);

namespace Infinite;

use Closure;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use WeakReference;

class Theme implements ExtensionInterface
{
    private $container;

    public function __construct(
        $container
    ) {
        $this->container = WeakReference::create($container);
    }

    public function register(Engine $engine): void
    {
        // Pass pathFor to plates template
        $engine->registerFunction('getUrl', Closure::bind(function ($string, $arguments = []) {
            try {
                return ROOT_URL . substr($this->container->get()->get('router')->urlFor($string, $arguments), 1);
            } catch (\Exception $e) {
                // do nothing
            }
        }, $this));
        $engine->registerFunction('getAssets', Closure::bind(function () {
            return $this->container->get()->get('assets');
        }, $this));
        // $engine->registerFunction('getCsrf', Closure::bind(function () {
        //     return $this->container->get()->get('csrf')();
        // }, $this));
        $engine->registerFunction('getSession', Closure::bind(function () {
            return $this->container->get()->get('session')();
        }, $this));
        $engine->registerFunction('getMessages', Closure::bind(function () {
            return $this->container->get()->get('flash');
        }, $this));
    }
}
