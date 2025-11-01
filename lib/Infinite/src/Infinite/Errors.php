<?php

declare(strict_types=1);

namespace Infinite;

use Camspiers\JsonPretty\JsonPretty;
use Wa72\SimpleLogger\FileLogger;

class Errors
{
    /**
     * Logger
     *
     * @var FileLogger
     */
    private $logger;

    /**
     * @param FileLogger $logger
     * @return void
     */
    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    public function _construct()
    {
        \register_shutdown_function([$this, "fatalHandler"]);
    }

    /**
     * @return void
     */
    public static function createLogsDir(): void
    {
        if (!\is_dir(ROOT . '/logs')) {
            \mkdir(ROOT . '/logs');
        }
    }

    /**
     * @return void
     */
    public function fatalHandler(): void
    {
        $logger = $this->logger;
        $errfile = "unknown file";
        $errstr  = "shutdown";
        $errno   = E_CORE_ERROR;
        $errline = 0;

        $error = error_get_last();
        if ($error !== null) {
            $errno   = $error["type"];
            $errfile = $error["file"];
            $errline = $error["line"];
            $errstr  = $error["message"];
            \ob_clean();
            $this->jsonPretty($this->formatError([$errno, $errstr, $errfile, $errline]));
        }
    }

    /**
     * @param array $errno
     * @return array
     */
    public function formatError(array $debug): array
    {
        // $debug = debug_backtrace(2);
        // unset($debug[0]['file']);
        // unset($debug[0]['function']);
        // unset($debug[0]['class']);
        // unset($debug[0]['line']);
        echo '<pre>'; //print_r($debug);die;
        // $trace = json_encode($debug);

        $data = ['type', 'error', 'file', 'line'];
        if (!isset($debug)) {
            // $debug[0]['args'] = [];
            // print_r($debug);exit;
            return [];
        }
        $count = 1000;
        $debug[1] = \str_replace('\/', '//', $debug[1], $count);
        $arr = \array_combine($data, $debug);

        $content = $arr;
        if (PRODUCTION_MODE == 1) {
            $content = ['Something went wrong, please check errors log file.'];
        }
        $this->logger->log($errno, \json_encode($arr));
        return $content;
    }

    /**
     * @param array $json
     * @return void
     */
    public function jsonPretty(array $json): void
    {
        if (\is_array($json)) {
            // print the error
            \print_r($json);
        }
    }
}
