<?php


/**
 * Object MVC Example app 
 *
 * @author Alexandr Gorlov <a.gorlov@gmail.com>
 */

require_once '../vendor/autoload.php';

use AG\WebApp\App;
use AG\WebApp\AccessDeniedException;
use AG\WebApp\NotFoundException;
use AG\WebApp\ApplicationStd;
use AG\WebApp\Request;
use AG\WebApp\Request\RqGET;
use AG\WebApp\Request\RqPOST;
use AG\WebApp\Response;
use AG\WebApp\Response\RespStd;
use AG\WebApp\Action;
use AG\WebApp\Action\ActRedirect;
use AG\WebApp\Session;
use AG\WebApp\Session\AppSession;

use ExampleApp\ActIndex;
use ExampleApp\ActIndexTwig;
use ExampleApp\ActLogin;
use ExampleApp\ActLogout;
use ExampleApp\ActLk;

(new ApplicationStd(
    [
        '/' => new ActIndexTwig(),
        '/login' => new ActLogin(),
        '/logout' => new ActLogout(),
        '/lk' => new ActLk(),
    ],
    new RespStd
))->start();
