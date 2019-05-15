<?php

require_once './vendor/autoload.php';

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
use AG\WebApp\Session;

/**
 * Object MVC Prototype
 *
 * @author Alexandr Gorlov <a.gorlov@gmail.com>
 */

//require __DIR__ . '/vendor/autoload.php';

// config
// env
// http-request
// session
// $db


interface Config
{
    //...
}



class AppSession implements Session
{
    public function exists($param): bool
    {
        $this->sessionStart();
        return array_key_exists($param, $_SESSION);
    }

    public function get($param)
    {
        $this->sessionStart();
        return $_SESSION[$param] ?? null;
    }

    public function set($param, $value): void
    {
        $this->sessionStart();
        $_SESSION[$param] = $value;
        session_commit();
    }

    public function unset($param): void
    {
        $this->sessionStart();
        unset($_SESSION[$param]);
        session_commit();
    }

    private function sessionStart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}

class AppPDO extends PDO
{
    public function __construct(AppConfig $config)
    {
//        parent::__construct($dsn, $username, $passwd, $options);
    }
}

class ActIndex implements Action
{
    private $rqGet;

    public function __construct(Request $req = null /*, PDO $db, Config $config, Env $env, Session $sess, Tpl $tpl*/)
    {
        $this->rqGet = $req ?? new RqGET();
//        $this->db = $db ?? new AppPDO;
//        $this->config = $config ?? new AppConfig;
//        $this->env = $env ?? new AppEnv;
//        $this->session = $sesss ?? new AppSession;
//        $this->tpl = $tpl ?? new AppTpl;
    }

    public function handle(Response $resp): Response
    {
        return $resp->withBody(
            "Hello, World 2!<br>" . 
            '<a href="/login">login</a>'
        );
    }
}


class ActRedirect implements Action
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function handle(Response $resp): Response
    {
        return $resp
            ->withBody('Redirect: ' . $this->url)
            ->withHeaders([ 'Location: ' . $this->url ]);
    }
}


class ActLogin implements Action
{
    private $session;
    private $redirect;

    public function __construct(
        Session $sess = null,
        Action $redirect = null // Request $req = null , PDO $db, Config $config, Env $env, Session $sess, Tpl $tpl
    ) {
        $this->session = $sess ?? new AppSession;
        $this->redirect = $redirect ?? new ActRedirect('/lk');
//        $this->rqGet = $req ?? new RqGET();
//        $this->db = $db ?? new AppPDO;
//        $this->config = $config ?? new AppConfig;
//        $this->env = $env ?? new AppEnv;
//        $this->tpl = $tpl ?? new AppTpl;
    }

    public function handle(Response $resp): Response
    {
        if (true) { //  login and password ok
            $this->session->set('login', 'user1');
            return $this->redirect->handle($resp);
        } else {
            return $this->response->withBody(
                "Bad login or password."
            );
        }
    }
}


class ActLogout implements Action
{
    private $session;
    private $redirect;

    public function __construct(
        Session $sess = null,
        Action $redirect = null // Request $req = null , PDO $db, Config $config, Env $env, Session $sess, Tpl $tpl
    ) {
        $this->session = $sess ?? new AppSession;
        $this->redirect = $redirect ?? new ActRedirect('/');
//        $this->rqGet = $req ?? new RqGET();
//        $this->db = $db ?? new AppPDO;
//        $this->config = $config ?? new AppConfig;
//        $this->env = $env ?? new AppEnv;
//        $this->tpl = $tpl ?? new AppTpl;
    }

    public function handle(Response $resp): Response
    {
        if ($this->session->exists('login')) { //  login and password ok
            $this->session->unset('login');
            return $this->redirect->handle($resp);
        }

        return $this->response->withBody(
            "You are not logged in."
        );
    }
}



class ActLk implements Action
{
    private $sess;
    private $redirect;

    public function __construct(
        Session $sess = null
        //Action $redirect = null // Request $req = null , PDO $db, Config $config, Env $env, Session $sess, Tpl $tpl
    ) {
        $this->sess = $sess ?? new AppSession;
        //$this->redirect = $redirect ?? new ActRedirect('/');
//        $this->rqGet = $req ?? new RqGET();
//        $this->db = $db ?? new AppPDO;
//        $this->config = $config ?? new AppConfig;
//        $this->env = $env ?? new AppEnv;
//        $this->tpl = $tpl ?? new AppTpl;
    }

    public function handle(Response $resp): Response
    {
        if (! $this->sess->exists('login')) { //  login and password ok
            throw new AccessDeniedException('Only Authorized Access');
        }

        return $resp->withBody(
            "Hello: " . $this->sess->get('login') . "<br>" .
            '<a href="/logout">logout</a>'
        );
    }
}



(new ApplicationStd(
    [
        '/' => new ActIndex(),
        '/login' => new ActLogin(),
        '/logout' => new ActLogout(),
        '/lk' => new ActLk(),
    ],
    new RespStd // AppResponse
    /*
    new class() implements Request {
    public function param($param) {
    return '/login';
    }
    }
    */
))->start();
