<?php

namespace Core\Controller;

use Attribute;

#[Attribute]
class Route
{
    public function __construct(public string $routePath, public string $name, public string $method = 'GET')
    {
    }
}
