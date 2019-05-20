<?php

namespace AG\WebApp;

class AppPDO extends PDO
{
    public function __construct(Config $config)
    {
        // $config->param('dbname')
        // $config->param('dbpass')
        // $config->param('dbuser')
        // $config->param('dbhost')
        parent::__construct($dsn, $username, $passwd, $options);
    }
}
