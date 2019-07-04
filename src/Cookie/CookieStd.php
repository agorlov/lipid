<?php

namespace Lipid\Cookie;

use Lipid\Cookie;
use Exception;

/**
 * Http cookie
 *
 * @author Alexandr Gorlov
 */
final class CookieStd implements Cookie
{
    /**
     * Is cookie exists
     */
    public function exists($name): bool
    {
        return array_key_exists($name, $_COOKIE);
    }

    /**
     * Get cookie
     */
    public function get($name) : string
    {
        if ($this->exists($name)) {
            return $_COOKIE[$name];
        } else {
            throw new Exception("Cookie name=$name absents");
        }
    }

    /**
     * Sets cookie
     *
     * @link https://www.php.net/manual/ru/function.setcookie.php
     */
    public function set(
        $name,
        $value = "",
        int $expire = 0,
        string $path = "",
        string $domain = "",
        bool $secire = false,
        bool $httponly = false
    ): void {
        if (setcookie($name, $value, $expire, $path, $domain, $secire, $httponly) === false) {
            throw new Exception("Error setting cookie name=$name value=$value");
        }
    }

    /**
     * Remove var from http-cookies
     */
    public function unset($name): void
    {
        $this->set($name, "", time() - 3600);
    }
}
