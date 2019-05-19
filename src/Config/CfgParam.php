<?php

namespace AG\WebApp\Config;

use AG\WebApp\Config;

/**
 * String param form config file
 *
 * new CfgParam('key', Config)->__toString(): string;
 * or
 * new CfgParam('key', Config)->val(): string;
 *
 * @todo Doubtful usefulness of this object. 
 * @author agorlov
 */
class CfgParam // implements string 
{
    private $key;
    private $cfg;

    public function __construct($key, Config $cfg) {
        $this->key = $key;
        $this->cfg = $cfg;
    }

    public function __toString() {
        return $this->val();
    }

    public function val() {
        return $this->cfg->param($this->key);
    }    
}
