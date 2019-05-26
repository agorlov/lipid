<?php

namespace ExampleApp;

use Lipid\Action;
use Lipid\Action\ActRedirect;
use Lipid\Request;
use Lipid\Request\RqGET;
use Lipid\Response;
use Lipid\Session;
use Lipid\Session\AppSession;

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
