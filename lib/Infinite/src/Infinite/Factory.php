<?php

declare(strict_types=1);

namespace Infinite;

use WeakReference;

class Factory
{
    private static $map = [];

    private static $mapClass;

    public function checkClassMap(array $map = []): void
    {
        $map = \array_unique($map);
        $newMap = [];
        foreach ($map as $key => $value) {
            if (empty($key) || empty($value)) {
                continue;
            }
            if (isset($newMap[$key])) {
                throw new \Exception('Class map duplicate item found');
                continue;
            }
            $newMap[$key] = $value;
        }
    }

    public function get(string $key): mixed
    {
        if (isset(self::$map[$key])) {
            return self::$map[$key];
        }
        return '';
    }

    /**
     * @param string $key
     * @param mixed $class
     */
    public function set(string $key, mixed $class): mixed
    {
        if (\is_object($class)) {
            self::$map[$key] = $class;
        } else {
            self::$map[$key] = $class;
        }
        return self::$map[$key];
    }

    /**
     * @param mixed $key
     */
    public function isExists($key): bool
    {
        return (bool) isset(self::$map[$key]);
    }

    /**
     * @param mixed $key
     */
    public function getClass($key): object
    {
        if (isset(self::$mapClass[$key])) {
            return self::$map[$key];
        } else {
            self::$mapClass[$key] = new self::$mapClass[$key]();
            return self::$mapClass[$key];
        }
    }
}
