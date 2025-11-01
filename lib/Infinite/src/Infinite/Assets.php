<?php

declare(strict_types=1);

namespace Infinite;

class Assets
{
    private static $data;

    /**
     * @param mixed $data
     */
    public function __construct($data)
    {
        self::$data = $data;
    }

    // public function validate()
    // {
    // }

    /**
     * @param string $file
     */
    public function getAssetPath(string $file): string
    {
        $basePath = $file;
        if (\strpos($file, '::', 0) > 0) {
            $basePath = 'assets/' . \str_replace('::', '/', $file);
        }

        if ($this->isCdn()) {
            return $this->getCdn() . $basePath;
        } else {
            // If not Cdn then generate url that can be handle using Core route - "assets"
            return ROOT_URL . $basePath;
        }
    }

    public function getCdn(): string
    {
        return $this->data()['cdn'];
    }

    public function isCdn(): bool
    {
        return (isset($this->data()['is_cdn']) && isset($this->data()['cdn']) ? $this->data()['is_cdn'] : false);
    }

    public function data(): array
    {
        return self::$data;
    }

    public function getBaseUrl(): string
    {
        return ROOT_URL;
    }
}
