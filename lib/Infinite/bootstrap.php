<?php
// phpcs:ignoreFile

declare(strict_types=1);

// TODO convert this file into small files
// session_cache_limiter('');
if (session_status() == PHP_SESSION_NONE) {
    // session_start();
}
// TODO: replace auro/session with https://github.com/adbario/slim-secure-session-middleware

// Added PSR-2 support to Infinite classes
use Infinite\Infinite;

error_reporting(E_ALL);
ini_set('display_errors', '1');
/*
For production use

$configuration = [];

if (defined('PRODUCTION_MODE')) {
    if (PRODUCTION_MODE == 0) {
        $configuration = [
            'settings' => [
                'httpVersion' => '1.1',
                'displayErrorDetails' => true,
                'determineRouteBeforeAppMiddleware' => true,
                 // Enable if production mode
                'routerCacheFile' => (PRODUCTION_MODE ? ROOT . '/cache/routecache' : false),
            ],
        ];
    }
}
*/

(static function (): void {
    define("ROOT", $_SERVER['DOCUMENT_ROOT']);
    $root = str_replace('/index.php', '', $_SERVER['PHP_SELF']);
    if ($root) {
        $root .= "/";
    }
    define("SCHEMA", $_SERVER['REQUEST_SCHEME'] . "://");
    define("ROOT_URL", SCHEMA . $_SERVER['HTTP_HOST'] . '/' . $root);

    $BASE = $_SERVER['DOCUMENT_ROOT'];
    $autoload = realpath($BASE . '/vendor/autoload.php');
    require_once $autoload;

    new Infinite();
})();
