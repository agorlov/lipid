<?php

namespace Lipid\Request;

use Lipid\Request;

final class RqSERVER implements Request
{

    private $request;

    public function __construct(array $request = null)
    {
        $this->request = $request ?? $_SERVER;
    }

    public function param($param)
    {
        return $this->request[$param] ?? null;
    }
}
