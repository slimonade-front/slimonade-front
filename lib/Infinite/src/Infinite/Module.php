<?php

declare(strict_types=1);

namespace Infinite;

class Module
{
    public function getModulePath(string $moduleName): string
    {
        return ROOT . '/app/' . $moduleName;
    }

    public function getViewPath(string $moduleName, array $args = null): string
    {
        $imp = $args ? \implode('/', $args) : '';
        return ROOT . '/app/' . $moduleName . '/Views/' . $imp;
    }

    /**
     * @return string|false
     */
    public function getConfig(string $moduleName)
    {
        $path = ROOT . '/app/' . $moduleName . 'config.json';
        if (\file_exists($path)) {
            return \json_encode(\file_get_contents($path));
        }
        return false;
    }

    /**
     * @return string|false
     */
    public function isModuleEnable(string $moduleName)
    {
        $path = ROOT . '/config/extensions.json';
        if (\file_exists($path)) {
            $json = \json_decode(\file_get_contents($path), true);
            return $json['extensions'][$moduleName];
        }
        return false;
    }
}
