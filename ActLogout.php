<?php

namespace ExampleApp;

use AG\WebApp\Action;
use AG\WebApp\Action\ActRedirect;
use AG\WebApp\Request;
use AG\WebApp\Request\RqGET;
use AG\WebApp\Response;
use AG\WebApp\Session;
use AG\WebApp\Session\AppSession;

class ActLogout implements Action
{
    private $session;
    private $redirect;

    public function __construct(
        Session $sess = null,
        Action $redirect = null
    ) {
        $this->session = $sess ?? new AppSession;
        $this->redirect = $redirect ?? new ActRedirect('/');
    }

    public function handle(Response $resp): Response
    {
        if ($this->session->exists('login')) { //  login and password ok
            $this->session->unset('login');
            return $this->redirect->handle($resp);
        }

        return $this->response->withBody(
            "You are not logged in."
        );
    }
}
