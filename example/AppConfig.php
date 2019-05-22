<?php

namespace ExampleApp;

use AG\WebApp\Config;
use AG\WebApp\Config\CfgArr;

/**
 * Application configuration parameters
 *
 * @author agorlov
 */
final class AppConfig implements Config
{
    private $cfg;
    public function __construct(Config $cfg = null)
    {
        $this->cfg = $cfg ?? new CfgArr([
            // DB Connection
            'dbhost' => '127.0.0.1',
            'dbname' => 'glavpunkt',
            'dbuser' => 'glavpunkt',
            'dbpass' => 'glavpunkt',
        ]);
    }

    public function param(string $name)
    {
        return $this->cfg->param($name);
    }
}
