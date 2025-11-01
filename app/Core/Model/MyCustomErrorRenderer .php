<?php

namespace Core\Model;

use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class MyCustomErrorRenderer implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        return 'My awesome format';
    }
}
