# Lipid

[![Hits-of-Code](https://hitsofcode.com/github/agorlov/lipid)](https://hitsofcode.com/view/github/agorlov/lipid)

Lipid is an objects designed microframework for PHP web apps.


## Quickstart

Create app directory:

```sh
$ mkdir testapp
```

Create ``composer.json`` like this:
```json
{
    "require": {
        "agorlov/lipid": "master@dev"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:agorlov/lipid"
        }
    ]
}
```
Run composer update:

```
$ composer update
```

Start with example app:

index.php:
```php
<?php

require_once './vendor/autoload.php';

use Lipid\App\ApplicationStd;
use Lipid\Response\RespStd;
use ExampleApp\ActIndex;
use ExampleApp\ActLogin;
use ExampleApp\ActLogout;
use ExampleApp\ActLk;

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

Create your own Action:
@todo ...

Create your own Template:
@todo ...



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
    $this->config = $config ?? new CfgFile;
    $this->env = $env ?? new AppEnv;
    $this->tpl = $tpl ?? new AppTpl
}
```

## Design principles

1. True OOP: 
  - each object is representation of domain term
  - no static,
  - small objects, 
  - without extends, 
  - wide use of decorators,
  - strict piplene: unit tests, PSR2 checker, 
  - 

inspired by @yegor256 Elegant Objects

2. Micro-format, like lipid is.

3. 

## Library development cycle

1. Clone repository
2. ``$ composer install``
3. ``$ composer dump-autoload``
4. ``$ composer example``
5. open browser: http://localhost:8000/
6. look at the source code: example/ directory.

7. Put some changes, create branch for issue:
```
$ git checkout -b 'Issue123'
```

8. Check and fix PSR2
`` $ composer phpcs `` and `` $composer phpcs-fix ``

9. Check by unit tests:
```
$ composer tests
```

10. commit, push and create PR.
```
git commit -m 'Thats was done closes #123' -a
git push --set-upstream origin Issue123
```
