<?php

namespace AG\WebApp\App;

use Exception;
use AG\WebApp\App;
use AG\WebApp\Response;
use AG\WebApp\Response\RespStd;
use AG\WebApp\Action;
use AG\WebApp\Action\ActRouted;
use AG\WebApp\Request;
use AG\WebApp\Request\RqSERVER;
use AG\WebApp\NotFoundException;
use AG\WebApp\AccessDeniedException;

final class ApplicationStd implements App
{
    private $action;
    private $response;

    /**
     * Application constructor.
     *
     * @param Action|array $action action to start (see ActRouted)
     * @param Response $response HTTP Response
     * @param Request $request HTTP Request
     */
    public function __construct($action, Response $response = null, Request $SERVER = null)
    {
        if ($action instanceof Action) {
            $this->action = $action;
        } elseif (is_array($action)) {
            $this->action = new ActRouted(
                $SERVER ?? new RqSERVER(),
                $action
            );
        } else {
            throw new Exception("\$action must be array or Request-object");
        }

        $this->response = $response ?? new RespStd;
    }

    public function start(): void
    {
        try {
            $this->action->handle($this->response)->print();
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
