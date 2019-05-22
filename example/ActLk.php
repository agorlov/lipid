<?php

namespace ExampleApp;

use AG\WebApp\Action;
use AG\WebApp\Request;
use AG\WebApp\Response;
use AG\WebApp\Session;
use AG\WebApp\Session\AppSession;
use AG\WebApp\AccessDeniedException;
use AG\WebApp\Config;
use AG\WebApp\Config\CfgParam;
//use AG\WebApp\AccessDeniedException;
use PDO;

final class ActLk implements Action
{
    private $sess;
    private $config;

    public function __construct(
        Session $sess = null,
        Config $config = null,
        PDO $pdo = null
    ) {
        $this->sess = $sess ?? new AppSession();
        $this->config = $config ?? new AppConfig();
        $this->cfgDbname = new CfgParam('dbname', $this->config);
        $this->pdo = $pdo ?? new AppPDO();
    }

    public function handle(Response $resp): Response
    {
        if (! $this->sess->exists('login')) {
            throw new AccessDeniedException('Only Authorized Access');
        }

        $this->pdo->quote("Test string!");

        //  login and password are ok

        return $resp->withBody(
            "Hello: " . $this->sess->get('login') . "<br>" .
            '<a href="/logout">logout</a><br>' .
            'Config var dbname=' . $this->config->param('dbname') . "<br>" .
            'Config var dbname=' . $this->cfgDbname->val()
        );
    }
}
