<?php

namespace ExampleApp;

use AG\WebApp\Action;
use AG\WebApp\Action\ActRedirect;
use AG\WebApp\Request;
use AG\WebApp\Request\RqGET;
use AG\WebApp\Response;
use AG\WebApp\Session;
use AG\WebApp\Session\AppSession;

final class ActLogin implements Action
{
    private $session;
    private $redirect;

    public function __construct(
        Session $sess = null,
        Action $redirect = null
    ) {
        $this->session = $sess ?? new AppSession;
        $this->redirect = $redirect ?? new ActRedirect('/lk');
    }

    public function handle(Response $resp): Response
    {
        if (true) { //  login and password ok
            $this->session->set('login', 'user1');
            return $this->redirect->handle($resp);
        } else {
            return $this->response->withBody(
                "Bad login or password."
            );
        }
    }
}
