# ObjectMVC

PHP Object MVC microframework for web apps

## Quickstart

1. Clone repository
2. ``$ composer install``
3. ``$ composer dump-autoload``
4. ``$ composer example``
5. open browser: http://localhost:8000/
6. look at the source code: example/ directory.

# Example Application

index.php:
```php
(new ApplicationStd(
    [
        '/' => new ActIndex(),
        '/login' => new ActLogin(),
        '/logout' => new ActLogout(),
        '/lk' => new ActLk(),
    ],
    new RespStd
))->start();
```

## Actions

**ActIndex.php**

```php
class ActIndex implements Action
{
    public function handle(Response $resp): Response
    {
        return $resp->withBody(
            "Hello, World 2!<br>" . 
            '<a href="/login">login</a>'
        );
    }
}
```

If we need database or GET params, put it in constructor:

In this example $_GET['test'] -> with RqGET object

```php

class ActIndex implements Action
{
    private $rqGet;

    public function __construct(Request $rqGet = null)
    {
        $this->rqGet = $rqGet ?? new RqGET();
    }

    public function handle(Response $resp): Response
    {
        $test = $this->rqGet->param('test') ?? 'nothing';

        return $resp->withBody(
            "Hello, World 2!<br>" . 
            '<a href="/login">login</a>' .
            '$_GET[test]=' . htmlentities($test)
        );
    }
}
```

GET request, POST request, Database, Config, Environment, Session:
```php
public function __construct(
    Request $req = null, 
    AppPDO $db = null, 
    Config $config = null, 
    Env $env = null,
    Session $sess = null,
    Tpl $tpl
    // or anything you need for your Action
) 
{
    $this->rqPOST = $req ?? new RqGET();
    $this->rqGET = $req ?? new RqGET();
    $this->db = $db ?? new AppPDO;
    $this->config = $config ?? new AppConfig;
    $this->env = $env ?? new AppEnv;
    $this->tpl = $tpl ?? new AppTpl
}
```
