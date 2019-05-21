<?php

namespace AG\WebApp\App;

use Exception;
use AG\WebApp\App;
use AG\WebApp\Response;
use AG\WebApp\Request;
use AG\WebApp\Request\RqSERVER;
use AG\WebApp\NotFoundException;
use AG\WebApp\AccessDeniedException;

class ApplicationStd implements App
{
    private $actions;
    private $SERVER;

    /**
     * Application constructor.
     *
     * @param Response|array $action
     */
    public function __construct(array $actions, Response $response = null, Request $SERVER = null)
    {

        $this->SERVER = $SERVER ?? new RqSERVER();
        $this->actions = $actions;
        $this->response = $response; // ?? new AppResponse;
    }

    public function start(): void
    {
        try {
            $requestUri = $this->SERVER->param('REQUEST_URI');

            if (! array_key_exists($requestUri, $this->actions)) {
                throw new NotFoundException('Page=' . $requestUri . ' not found in actions list!');
            }

            $resp = $this->actions[$requestUri]->handle($this->response);
            $resp->print();
        } catch (NotFoundException $e) {
            header("Status: 404 Not Found");
            echo '404! ' . $e->getMessage();
        } catch (AccessDeniedException $e) {
            header("Status: 403 Access denied");
            echo '403! ' . $e->getMessage();
        } catch (Exception $e) {
            header("Status: 500 Application Error");
            echo "<h1>Error</h1>";
            echo "<pre>" . $e . "</pre>";
        }
    }
}
