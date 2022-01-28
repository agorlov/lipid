<?php

namespace Lipid\Config;

use Lipid\Config;

/**
 * Config based on php-file
 *
 * Be default it is: ``config.php``
 *
 * Config file example:
 *
 * ```
 * <?php
 *
 * return [
 *    'dbhost' => '127.0.0.1',
 *    'dbname' => 'myapp',
 *    'dbuser' => 'user',
 *    'dbpass' => 'password',
 * ];
 *
 * ```
 *
 * @author agorlov
 */
final class CfgFile implements Config
{
    private $cfg;

    /**
     * By default we get config from current work directory
     *
     * @param string $cfgPath path to config php file
     * @param Config $cfg
     */
    public function __construct(string $cfgPath = null, Config $cfg = null)
    {
        $cfgPath = $cfgPath ?? getcwd() . '/config.php';
        
        $this->cfg = function () use ($cfg, $cfgPath) {
            return $cfg ?? new CfgArr(require $cfgPath);
        };
    }

    public function param(string $name)
    {
        return $this->cfg->call($this)->param($name);
    }
}
