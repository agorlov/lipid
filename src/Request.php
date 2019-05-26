<?php

namespace Lipid;

/**
 * Request
 *
 * Some part of request, it may be GET/POST param
 *
 * @author agorlov
 */
interface Request
{
    /**
     * Request parameter value
     *
     * @param string $param parameter name (example: GET parameter name)
     * @return mixed parameter value
     */
    public function param($param);
}
