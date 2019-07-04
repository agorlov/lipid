<?php

namespace Lipid;

/**
 * Request
 *
 * Some part of request, it may be GET/POST param
 *
 * @todo Create individual interfaces for each kind of Request/* ENV/POST/GET
 *       For example POST, is not only param, but also body, files
 *       Cookie has also setting method.
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
