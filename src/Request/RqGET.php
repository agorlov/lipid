<?php
namespace AG\WebApp\Request;

use AG\WebApp\Request;

class RqGET implements Request
{
    private $request;

    public function __construct(array $request = null)
    {
        $this->request = $request ?? $_GET;
    }

    public function param($param)
    {
        return $this->request[$param] ?? null;
    }
}
