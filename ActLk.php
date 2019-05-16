<?php

namespace ExampleApp;

use AG\WebApp\Action;
use AG\WebApp\Action\ActRedirect;
use AG\WebApp\Request;
use AG\WebApp\Response;
use AG\WebApp\Session;
use AG\WebApp\Session\AppSession;
use AG\WebApp\AccessDeniedException;

class ActLk implements Action
{
    private $sess;
    private $redirect;

    public function __construct(
        Session $sess = null
    ) {
        $this->sess = $sess ?? new AppSession;
    }

    public function handle(Response $resp): Response
    {
        if (! $this->sess->exists('login')) {
            throw new AccessDeniedException('Only Authorized Access');
        }

        //  login and password are ok

        return $resp->withBody(
            "Hello: " . $this->sess->get('login') . "<br>" .
            '<a href="/logout">logout</a>'
        );
    }
}
