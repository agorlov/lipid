<?php

namespace ExampleApp;

use AG\WebApp\Action;
use AG\WebApp\Request;
use AG\WebApp\Request\RqGET;
use AG\WebApp\Response;
use AG\WebApp\Tpl;
use ExampleApp\AppTwig;

/**
 * Start page of example app.
 *
 * @author Alexandr Gorlov <a.gorlov@gmail.com>
 */
final class ActIndexTwig implements Action
{
    private $rqGet;
    private $tpl;

    public function __construct(Request $req = null, Tpl $tpl = null)
    {
        $this->rqGet = $req ?? new RqGET();
        $this->tpl = $tpl ?? new AppTwig('index.twig');
    }

    public function handle(Response $resp): Response
    {
        $test = $this->rqGet->param('test') ?? 'nope';
        

        return $resp->withBody(
            $this->tpl->render([
                'date' => new \DateTime('now'),
                'test' => $test
            ])
        );
    }
}
