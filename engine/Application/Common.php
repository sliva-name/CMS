<?php

namespace Engine\Application;

class Common
{
    public function isPost(): bool
    {
        return $this->getMethod() === 'POST';
    }

    public static function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return false|mixed|string
     */
    public static function getUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        if ($position = strpos($url, '?')) {
            $url = substr($url, "0", $position);
        }

        return $url;
    }

    public static function protocol(): string
    {
        return !empty($_SERVER['HTTPS']) ? 'https' : 'http';
    }
}
