<?php

namespace Lipid\Request;

use Lipid\Request;
use Exception;

/**
 * RqENV - PHP process environment (\$_ENV variable)
 *
 * @author agorlov
 */
final class RqENV implements Request
{

    private $env;

    public function __construct(array $env = null)
    {
        $this->env = $env ?? getenv();
    }

    public function param($param)
    {
        if (array_key_exists($param, $this->env)) {
            return $this->env[$param];
        } else {
            throw new Exception("Param=$param not defined in \$_ENV");
        }
    }
}
