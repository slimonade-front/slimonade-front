<?php

declare(strict_types=1);

namespace Infinite;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Wa72\SimpleLogger\FileLogger;
use Aura\Sql\ExtendedPdo;
use Core\Abstracts\AbstractEvents;
use Core\Abstracts\AbstractRoute;
use Fiber;
use Infinite\ExtendedGuard;
use Infinite\Errors;
use Infinite\Factory;
use Infinite\Assets;
use Slim\App;
// use Infinite\AbstractModel;
// use Infinite\Module;
// use Infinite\Theme;
// use Infinite\Setup;
// use Infinite\Events;
use Selective\Container\Container;
use Selective\Container\Resolver\ConstructorResolver;

class Infinite
{
    private array $enabledExtn;
    private array $middlewareAr;

    public function __construct()
    {
        $this->startErrorLogger();
        $this->startExtensions();

        $container = $this->startContainer();
        $this->startFactory($container);
        $this->startAssets($container);
        $this->startErrorHandler($container);
        // $this->startDatabase($container);
        $app = $this->startApp($container);
        $this->startSession($container, $app);
        $this->startFlash($container);
        $this->startView($container);
        $this->startSetup($app, $container);
        $this->startRoutes($app);
        $this->startMiddlewares($app);

        $customErrorHandler = function (
            \Psr\Http\Message\ServerRequestInterface $request,
            \Throwable $exception,
            bool $displayErrorDetails,
            bool $logErrors,
            bool $logErrorDetails
        ) use ($app, $container) {
            $e = $container->get('events');
            $v = $container->get('view');

            $m = $container->get('module');
            $layoutFile = $m->getViewPath('Main');

            $v->addFolder('content', $layoutFile, true);
            $v->addFolder('common', $layoutFile . 'page', true);
            $v->addFolder('template', $layoutFile . 'templates', true);

            $events = new AbstractEvents();
            $events->template = 'content::templates/404';
            $e->callback('before_404_load', $events);
            if (isset($request->getQueryParams()['clearcache'])) {
                \unlink(ROOT . '\cache\routecache');
            }
            $response = $app->getResponseFactory()->createResponse();
            $response->getBody()->write($v->render($events->template, ['title' => 'Oops! Page Not Found']));
            return $response->withStatus(404);
        };

        // Add error middleware
        $errorMiddleware = $app->addErrorMiddleware(true, true, true);
        $errorMiddleware->setErrorHandler('Slim\Exception\HttpNotFoundException',
        $customErrorHandler);

        // $errorMiddleware->setErrorHandler('Slim\Exception\HttpNotFoundException',
        // \Core\Model\MyCustomErrorRenderer::class, true);

        return $app->run();
    }

    private function startErrorLogger()
    {
        $fiber = new Fiber(function () {
            // Start error handling
            Errors::createLogsDir();
            if (!file_exists(__DIR__ . '/../../../../logs/errors.log')) {
                touch(__DIR__ . '/../../../../logs/errors.log');
            }
            new Errors(new FileLogger(\realpath(__DIR__ . '/../../../../logs/errors.log')));
        });

        $fiber->start();
    }
    private function startExtensions(): void
    {
        // Load extensions
        $fiber = new Fiber(function() {
            $extPath = \realpath(__DIR__ . '/../../../../config/extensions.json');
            $fileRes = \fopen($extPath, 'r');
            \stream_set_blocking($fileRes, false);
            $json = \json_decode(\fread($fileRes, \filesize($extPath)), true);
            $enabledExtn = [];
            foreach ($json['extensions'] as $name => $value) {
                if ($value === 1) {
                    $enabledExtn[] = $name;
                }
            }

            $this->startInjection($enabledExtn);
            $this->enabledExtn = $enabledExtn;
        });
        $fiber->start();
    }

    private function startInjection(array $enabledExtn): void
    {
        $this->middlewareAr = [];
        foreach ($enabledExtn as $extn) {
            $configPath = \realpath(__DIR__ . '/../../../../app/' . $extn . '/config.json');
            if (\file_exists($configPath)) {
                $fileStream = \fopen($configPath, 'r');
                \stream_set_blocking($fileStream, false);
                $configJson =  \json_decode(\fread($fileStream, \filesize($configPath)), true);
                if ($configJson['middlewares'] === 1) {
                    $class = '\\' . $extn . '\\Model\\Middleware';
                    $this->middlewareAr[] = $class;
                }
                // if ($configJson['container'] === 1) {
                //     $class = '\\' . $extn . '\\Model\\Injection';
                //     // new $class($c);
                //     // $cAdded = true;
                // }
            }
        }
    }

    private function startContainer(): Container
    {
        $container = new Container();
        // Enable autowiring
        $container->addResolver(new ConstructorResolver($container));

        return $container;
    }

    private function startAssets($container): void
    {
        $extPath = \realpath(__DIR__ . '/../../../../config/env.json');
        $fileStream = \fopen($extPath, 'r');
        \stream_set_blocking($fileStream, false);

        $json = \json_decode(\fread($fileStream, \filesize($extPath)), true)['assets'];
        $container->set('assets', new Assets($json));
    }

    private function startErrorHandler($container): void
    {
        $container->set('errorHandler', function () use ($container) {
            return function ($request, $response, $exception) use ($container) {
                return $container['response']->withStatus(510)
                                            ->withHeader('Content-Type', 'text/html')
                                            ->write('Something went wrong!');
            };
        });
    }

    private function startDatabase($container): void
    {
        $extPath = \realpath(__DIR__ . '/../../../../config/env.json');
        $json = \json_decode(\file_get_contents($extPath), true)['db'];
        // if (is_bool($json['lazy']) && $json['lazy'] == false) {
            // $pdo->connect();
        // }
        $container->set('pdo', new ExtendedPdo(
            'mysql:host=' . $json['host'] . ';dbname=' . $json['db'],
            $json['user'],
            $json['password'],
            $json['options'], // driver options as key-value pairs
            $json['attributes']  // attributes as key-value pairs
        ));
    }

    private function startFlash($container): void
    {
        // Register Flash provider
        // $container->set('flash', function () use ($container) {
        // if (!$container->get('factory')->isExists('flash')) {
        if (isset($_COOKIE)) {
            $container->set('flash', new \Slim\Flash\Messages($_COOKIE));
        }
        // }
        //     } else {
        //         return $container->get('factory')->get('flash');
        //     }
        // });
    }

    private function startView($container): void
    {
        // if ($container->get('factory')->get('view')) {
        //     return $container->get('factory')->get('view');
        // }
        // Added default theme path for fallback template support
        $coreFile = $container->get('module')->getViewPath('Core');
        $view = new \League\Plates\Engine($coreFile . 'page');
        $view->addData([
            'title' => 'Slimonade Front', // Default value
            'description' => 'Slimonade Front to speed up', // Default value
            'keyword' => 'slim,slimonade,slim,lemonade,front,web', // Default value
            'bodyBefore' => '',
            'bodyAfter' => '',
            'headBefore' => '',
            'headAfter' => '',
            'footBefore' => '',
            'footAfter' => '',
            'assets' => $container->get('assets'), // @deprecated
            'csrf' => $container->get('csrf'), // @deprecated
            'messages' => $container->get('flash') // @deprecated
        ]);
        // Load extension class to register extended functions
        $view->loadExtension(new Theme($container));
        $container->set('view', $view);
        // $container->get('factory')->set('view', $view);
    }

    private function startFactory($container)
    {
        /**
         * Remove static configuration and replace with db configuration where required
         */
        $factory = new Factory();

        // if (!$factory->isExists('module')) {
            $container->set('module', new Module(\realpath(__DIR__ . '/../../../../config/extensions.json')));
        // }
        // if (!$factory->isExists('log')) {
            $container->set('log', new FileLogger(__DIR__ . '/../../../../logs/errors.log'));
        // }

        $container->set('factory', $factory);
    }

    private function startSession($container, $app)
    {
        // $factory = $container->get('factory');
        // if (!$factory->isExists('session')) {
            $session_factory = new \Aura\Session\SessionFactory();
            $container->set('session', $session_factory->newInstance($_COOKIE));
        // }
        /**
         * This area will load config settings from db and used by various process
         */
        // if (!$factory->isExists('events')) {
            $container->set('events', new Events(ROOT . '/config/events.json', $container));
        // }
        // $csrf =
        // function () use ($app) {
            $csrf = [];
            // echo 23434;exit;
            $session = $container->get('session');
            $responseFactory = $app->getResponseFactory();
            $csrf = new ExtendedGuard(
                $responseFactory,
                'xxs_',
                $session,
                null,
                200,
                16,
                true
            );
            // $csrf->setPersistentTokenMode(true);
            // if (empty($csrf->getTokenName()) || empty($csrf->getTokenValue())) {
                // $csrf->setStorage();
                // $csrf->generateToken();
            // }

            // return $csrf;
        // };
        // $container->set('csrf', []);
        $container->set('csrf', $csrf);
        // $container = new \League\Container\Container();
        // $container->add('csrf', $csrf);

    }

    private function startApp($container): App
    {
        // Set container to app factory
        AppFactory::setContainer($container);

        /**
         * Instantiate App
         *
         * In order for the factory to work you need to ensure you have installed
         * a supported PSR-7 implementation of your choice e.g.: Slim PSR-7 and a supported
         * ServerRequest creator (included with Slim PSR-7)
         */
        $app = AppFactory::create();

        // Start PHP session
        // session_start();

        /**
         * To generate the route cache data, you need to set the file to one that does not exist in a writable directory.
         * After the file is generated on first run, only read permissions for the file are required.
         *
         * You may need to generate this file in a development environment and committing it to your project before deploying
         * if you don't have write permissions for the directory where the cache file resides on the server it is being deployed to
         */
        $routeCollector = $app->getRouteCollector();
        if (!\is_dir(ROOT . '/var/cache')) {
            \mkdir(ROOT . '/var/cache', recursive: true);
        }
        $routeCollector->setCacheFile(ROOT . '/var/cache/cache.file');

        return $app;
    }

    private function startRoutes($app): void
    {
        $abstractRoute = new AbstractRoute();
        $abstractRoute->app = $app;

        foreach ($this->enabledExtn as $extn) {
            $configPath = \realpath(__DIR__ . '/../../../../app/' . $extn . '/config.json');
            if (\file_exists($configPath)) {
                $configJson = \json_decode(\file_get_contents($configPath), true);
                if ($configJson['front_routes'] === 1) {
                    $reflectionRoute = new \ReflectionClass('\\' . $extn . '\\Controller\\RouteAbstract');

                    foreach ($reflectionRoute->getMethods() as $method) {
                        $attributes = $method->getAttributes();

                        foreach ($attributes as $attribute) {
                            $route = $attribute->newInstance();
                            if (!\in_array($route->method, ['GET','POST','PUT','DELETE','OPTIONS','PATCH'])) {
                                throw new \Exception('invalid method found - ' . $route->method . ' for ' . $extn . '\Controller\RouteAbstract' . ':' . $method->getName());
                            }
                            $app->{\strtolower($route->method)}($route->routePath,  $extn . '\Controller\RouteAbstract' . ':' . $method->getName())->setName($route->name);
                        }
                    }

                    $class = '\\' . $extn . '\\Controller\\Routes';
                    if (\class_exists($class)) {
                        new $class($app);
                    }
                }
                if ($configJson['admin_routes'] === 1) {
                    $class = '\\' . $extn . '\\Controller\\AdminRoutes';
                    new $class($app);
                }
            }
        }
    }

    private function startMiddlewares(App $app): void
    {
        if (!empty($this->middlewareAr)) {
            $class = '';
            foreach ($this->middlewareAr as $class) {
                new $class($app);
            }
        }

//         $parsing = function ($input) {
// echo 134;exit;
//             return true;
//         };

        // $app->addBodyParsingMiddleware([
        //     "text/css" => $parsing
        // ]);

        $app->addRoutingMiddleware();
    }
    private function startSetup(App $app, $container): void
    {
        new Setup($app, $container);
    }
}
