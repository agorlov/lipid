<?php

namespace ExampleApp;

use Lipid\Action;
use Lipid\Request;
use Lipid\Request\RqGET;
use Lipid\Response;

/**
 * Start page of example app.
 *
 * @author Alexandr Gorlov <a.gorlov@gmail.com>
 */
final class ActIndex implements Action
{
    private $rqGet;

    public function __construct(Request $req = null)
    {
        $this->rqGet = $req ?? new RqGET();
    }

    public function handle(Response $resp): Response
    {
        $test = $this->rqGet->param('test') ?? 'nope';

        return $resp->withBody(
            "Hello, World 2!<br>" .
            '<a href="/login">login</a><br>' .
            '$_GET[test]=' . htmlentities($test)
        );
    }
}
