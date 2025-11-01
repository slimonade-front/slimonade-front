<?php

declare(strict_types=1);

namespace Infinite;

class Events
{
    private static $events;
    private $container;

    public function __construct($path, $container)
    {
        $events = \json_decode(\file_get_contents($path), true);
        $this->container = $container;
        $this->register($events);
    }
    private function register($events)
    {
        if (!empty($events['events'])) {
            self::$events = $events;
        }
    }
    public function callback($eventName, $args)
    {
        if (!$args instanceof \Core\Abstracts\AbstractEvents) {
            throw new \Exception(
                'Variable must be instance of \Core\Abstracts\AbstractEvents but found instance of ' . gettype($args)
            );
        }
        if (!empty(self::$events['events'])) {
            foreach (self::$events['events'] as $event => $func) {
                foreach ($func as $item) {
                    if (!isset($item)) {
                        continue;
                    }
                    if ($event === $eventName) {
                        $isOK = false;
                        try {
                            $exp = \explode('::', $item);
                            $class = $exp[0];
                            $class = '\\' . $class;
                            $function = $exp[1];
                            $obj = new $class($this->container);
                            $obj->$function($args);
                            $isOK = true;
                        } catch (\Exception $e) {
                            echo '#10: ' . $e->getMessage();
                        }
                    }
                }
            }
        }
    }
}
