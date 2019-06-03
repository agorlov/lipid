<?php

namespace Lipid\Config;

use Lipid\Config;
use Exception;

/**
 * App configuration based on creds.php and config.php files
 *
  * creds.php example
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
 * <?php
 *
 * return [
 *    'email' => 'test@example.org',
 *    'smtp' => '...',
 * ];
 *
 * ```
 *
 * @author agorlov
 */
final class Cfg implements Config
{
    private $creds;
    private $cfg;

    /**
     * By default we get config from current work directory
     *
     * @param Config $creds creds.php
     * @param Config $config config.php file
     */
    public function __construct(Config $creds = null, Config $config = null)
    {
        $credsPath = getcwd() . '/creds.php';
        $cfgPath = getcwd() . '/config.php';
        
        $this->creds = function () use ($creds, $credsPath) {
            return $creds ?? new CfgArr(require $credsPath);
        };

        $this->cfg = function () use ($config, $cfgPath) {
            return $config ?? new CfgArr(require $cfgPath);
        };
    }

    /**
     * Param from configuration
     *
     * First find it in creds.php, then in config.php
     *
     * @param string $name parameter name in configuration
     * @return mixed
     */
    public function param($name)
    {
        try {
            return $this->creds->call($this)->param($name);
        } catch (Exception $e) {
            return $this->cfg->call($this)->param($name);
        }
    }
}
