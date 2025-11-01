<?php

namespace Core\Controller;

// use Core\Abstracts\AbstractEvents;
use Psr\Http\Message\ServerRequestInterface;
use Core\Model\File;
use Selective\Container\Container;

class RouteAbstract
{
    private Container $container;

    private const APCU_PREFIX = 'assets_';


    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param $request \Psr\Http\Message\ServerRequestInterface
     * @param $response \Psr\Http\Message\ResponseInterface
     * @param $args
     */
    #[Route('/assets/{params:.*js|.*css|.*jpg|.*png}', 'core_assets', 'GET')]
    public function assets(ServerRequestInterface $request, $response, $args)
    {
        $n = $request->getHeaderLine('If-None-Match');
        $content = null;
        $params = $args['params'];
        $pos = strpos($params, '/');
        $path = null;

        if (!empty($params)) {
            $path = ROOT . '/app/' . substr_replace($params, '/assets', $pos, 0);
        }

        $mtime = "sl/" . @filemtime($path);
        $statusCode = 304;

        if ($n !== $mtime) {
            $statusCode = 200;

            if (file_exists($path) && is_readable($path) && !is_dir($path)) {
                # Processing
                $name = basename($path);
                // if ($file = $this->fetchApcu($name . $mtime)) {
                //     $content = $file;
                // }
                if (empty($content)) {
                    if ($fh = fopen($path, "rb")) {
                        $content = fread($fh, filesize($path));
                        // $content = trim(\file_get_contents($path));
                        $content = trim($content);
                        // $this->setApcu($name . $mtime, $content);
                        // fclose($fh);
                    }
                }
                empty($content) ? '' : $response->getBody()->write($content);
                // $response = $response->withHeader('ETag', $mtime);
                // $this->container->get('factory')->set('ETag', $mtime);
            } else {
                $statusCode = 400;
                $mtime = '';
            }
        } else {
            if (file_exists($path) && is_readable($path) && !is_dir($path)) {
                // $response = $response->withHeader('ETag', $mtime);
                // $this->container->get('factory')->set('ETag', $mtime);
            }
        }
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $type = 'text/plain';
        if (!empty(trim($ext))) {
            $type = File::getMimeType(strtolower($ext));
        }
        $this->container->get('factory')->set('file_type', $type);
        return $response->withStatus($statusCode);
    }

    // #[Route('/♪', 'core_music', 'GET')]
    public function music($request, $response, $args)
    {
        return $response->getBody()->write('Sing with me! >> ' . rawurlencode('♪'));
    }
    private function isApcuEnabled()
    {
        return function_exists('apcu_fetch') && ini_get('apc.enabled');
    }
    private function fetchApcu($key)
    {
        if (!$this->isApcuEnabled()) {
            return false;
        }
        $file = apcu_fetch('assets_' . $key, $hit);
        if ($hit) {
            return $file;
        }
        return false;
    }
    private function setApcu($key, $value)
    {
        if (!$this->isApcuEnabled()) {
            return false;
        }
        apcu_delete('assets_' . $key);
        apcu_add('assets_' . $key, $value);
        return true;
    }
}
