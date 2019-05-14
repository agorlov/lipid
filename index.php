<?php


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


interface App
{
    public function start(): void;
}

class NotFoundException extends Exception
{
}

class AccessDeniedException extends Exception
{
}


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
          

            //foreach ($this->response->headers() as $header) {
            //    header($header);
            //}

            //if ()

            //echo $this->response->body();

            //$this->response->handle()
        } catch (NotFoundException $e) {
            header("Status: 404 Not Found");
            echo '404! ' . $e->getMessage(); //$twig->render('404.twig', ['message' => $e->getMessage()]);
        } catch (AccessDeniedException $e) {
            header("Status: 403 Access denied");
            echo '403! ' . $e->getMessage(); //$twig->render('403.twig', ['message' => $e->getMessage()]);
        } catch (Exception $e) {
            header("Status: 500 Application Error");
            echo "<h1>Error</h1>";
            echo "<pre>" . $e . "</pre>";
        }
    }
}

interface Request
{
    public function param($param);
}

interface Response
{
    public function print(): void;
    public function withBody(string $body): Response;
    public function withHeaders(array $headers): Response;
}

class RespStd implements Response
{
    private $headers;
    private $body;
    public function __construct($body = '', $headers = [])
    {
        $this->body = $body;
        $this->headers = $headers;
    }

    public function withBody(string $body): Response
    {
        return new self($body, $this->headers);
    }

    public function withHeaders(array $headers): Response
    {
        return new self($this->body, $headers);
    }


    public function print(): void
    {
        foreach ($this->headers as $header) {
            header($header);
        }

        echo $this->body;
    }
}

class RqSERVER implements Request
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

class RqGET implements Request
{
    private $request;

    public function __construct(array $request = null)
    {
        $this->request = $request ?? $_GET;
    }

    public function param($param)
    {
        return $this->request[$param] ?? null;
    }
}

class RqPOST implements Request
{
    private $request;

    public function __construct(array $request = null)
    {
        $this->request = $request ?? $_POST;
    }

    public function param($param)
    {
        return $this->request[$param] ?? null;
    }
}

interface Config
{
    //...
}

interface Session
{
    public function exists($param): bool;

    public function get($param);

    public function set($param, $value): void;

    public function unset($param): void;
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


interface Action
{
    public function handle(Response $resp): Response;
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
        return $resp->withBody("Hello, World 2!");
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
            "Hello: " . $this->sess->get('login')
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
