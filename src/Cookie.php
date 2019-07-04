<?php


namespace Lipid;

interface Cookie
{
    public function exists($name): bool;

    public function get($name): string;

    /**
     * Sets http cookie
     *
     * Examples:
     * ```php
     * $cookies->set("TestCookie", $value);
     * $cookies->set("TestCookie", $value, time()+3600);  // expires in 1 hour
     * $cookies->set("TestCookie", $value, time()+3600, "/~rasmus/", "example.com", 1);
     * ```
     */
    public function set(
        $name,
        $value = "",
        int $expire = 0,
        string $path = "",
        string $domain = "",
        bool $secire = false,
        bool $httponly = false
    ): void;

    public function unset($name): void;
}
