<?php

namespace Core\Model;

use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class MyCustomErrorRenderer
{
    protected $response;

    public function __construct(
        \Psr\Http\Message\ResponseInterface $response
    )
    {
        $this->response = $response;
    }

    public function __invoke(\Nyholm\Psr7\ServerRequest $request, Throwable $exception, bool $displayErrorDetails): string
    {
    //     $serialized_exception = serialize($e);
    //     $whoops = new \Whoops\Run();
    //     $handler = new \Whoops\Handler\PrettyPageHandler();
    //     $handler->setEditor('vscode');
    //     $whoops->pushHandler($handler);
    //     $whoops->register();
    //     $whoops->handleException(unserialize($serialized_exception));
    //     return 'Error: ' . $exception->getMessage() . "\nFull Trace: " . $exception->getTraceAsString();

    // $response = new \Slim\Http\Response(404);
    // return $response->write("Page not found");
        return $this->response
            ->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Something went wrong!');
    }
}
