<?php

namespace ExampleApp;

use Lipid\Action;
use Lipid\Action\ActRedirect;
use Lipid\Request;
use Lipid\Request\RqGET;
use Lipid\Response;
use Lipid\Session;
use Lipid\Session\AppSession;

final class ActLogout implements Action
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

        return $resp->withBody(
            "You are not logged in."
        );
    }
}
