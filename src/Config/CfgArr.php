<?php

namespace AG\WebApp\Config;

use AG\WebApp\Config;

/**
 * Config based on array
 *
 * @author agorlov
 */
final class CfgArr implements Config
{
    private $cfgArr;

    public function __construct(array $cfg) {
        $this->cfgArr = $cfg;
    }

    public function param($name) {
        if (! array_key_exists($name, $this->cfgArr)) {
            throw new \Exception("Parameter '$name' not declared in config.");
        }
        return $this->cfgArr[$name];
    }
}
