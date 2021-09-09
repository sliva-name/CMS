<?php


namespace Engine\Application;


class Common
{
    public function isPost(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            return true;
        }
        return false;
    }
    public static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return false|mixed|string
     */
    public static function getUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        if ($position = strpos ($url, '?'))
        {
            $url = substr ($url, "0", $position);
        }

        return $url;
    }

    /**
     * @return string
     */
    public static function protocol(): string
    {
        return $_SERVER['PROTOCOL'] = !empty($_SERVER['HTTPS']) ? 'https' : 'http';
    }

}