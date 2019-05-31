<?php

namespace Lipid\Action;

use Lipid\Action;
use Lipid\Response;
use Lipid\Request;
use Lipid\NotFoundException;
use Lipid\Request\RqSERVER;
use Exception;

/**
 * Routed action
 *
 * Selects the appropriate action for a given link
 *
 * @author agorlov
 */
final class ActRouted implements Action
{
    private $request;
    private $actionMap;

    /**
     * Constructor.
     *
     * @param string|Request $path url path (examples: '/' '/page' '/api/list')
     *                             or Request object, which contains REQUEST_URI param.
     * @param array $actionMap list of application actions
     *     [
     *          '/' =>  new ActMain(),
     *          '/login' =>  new ActLogin(),
     *          '/logout' => new ActLogout()
     *     ]
     */
    public function __construct($path, array $actionMap = [])
    {
        if (is_string($path)) {
            $this->request = new RqSERVER([ 'REQUEST_URI' => $path ]);
        } elseif ($path instanceof Request) {
            $this->request = $path;
        } else {
            throw new Exception("\$path must be string or Request-object");
        }

        
        $this->actionMap = $actionMap;
    }

    public function handle(Response $resp): Response
    {
        $requestUri = $this->request->param('REQUEST_URI');
        if (is_null($requestUri)) {
            throw new Exception("Missing parameter REQUEST_URI in Request.");
        }

        $path = parse_url($requestUri)['path'];
        if (! (is_string($path) && strlen($path) > 0) ) {
            throw new Exception("Unrecognized path in REQUEST_URI");
        }


        $path = '/' . rtrim(substr($path, 1), '/');

        if (! array_key_exists($path, $this->actionMap)) {
            throw new NotFoundException('Path=' . $path . ' is not found in actions list!');
        }

        return $this->actionMap[$path]->handle($resp);
    }
}
