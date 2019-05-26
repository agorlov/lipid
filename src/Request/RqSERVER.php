<?php

namespace Lipid\Request;

use Lipid\Request;
use Exception;

/**
 * RqSERVER - representation of PHP \$_SERVER variable
 *
 * @author agorlov
 */
final class RqSERVER implements Request
{

    private $request;

    public function __construct(array $request = null)
    {
        $this->request = $request ?? $_SERVER;
    }

    public function param($param)
    {
        if (array_key_exists($param, $this->request)) {
            return $this->request[$param];
        } else {
            throw new Exception("Param=$param not defined in \$_SERVER");
        }
    }
}
