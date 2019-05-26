<?php

namespace Lipid\Action;

use Lipid\Action;
use Lipid\Response;

final class ActRedirect implements Action
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function handle(Response $resp): Response
    {
        return $resp
            ->withBody('Redirect: ' . $this->url)
            ->withHeaders([ 'Location: ' . $this->url ]);
    }
}
