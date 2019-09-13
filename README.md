# Lipid

[![Hits-of-Code](https://hitsofcode.com/github/agorlov/lipid)](https://hitsofcode.com/view/github/agorlov/lipid) [![Maintainability](https://api.codeclimate.com/v1/badges/81625ae51d51bd721b46/maintainability)](https://codeclimate.com/github/agorlov/lipid/maintainability) [![codecov](https://codecov.io/gh/agorlov/lipid/branch/master/graph/badge.svg)](https://codecov.io/gh/agorlov/lipid)

Lipid is an objects designed microframework for PHP web apps.


## Quickstart

Create app directory:

```sh
$ mkdir testapp
$ composer require agorlov/lipid
$ composer dump-autoload
```

Lipid is installed, start with example app, run:

```sh
$ vendor/bin/lipidstrap

```

3 files will be created:

- ``index.php`` - it's your app, it consists of actions-objects for each page or request;
- ``src/ActIndex.php`` - it's example action for main page;
- ``tpl/index.twig`` - it's example index page template. 


Now update autoload:

```
$ composer update
```

And start your app:

```
$ php -S localhost:8000 index.php
```

Finaly open browser:
http://localhost:8000

Enjoy Result and start creating your app pages.


## How to create Actions (pages or api-responses)

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


## PHPMD

To disable some nasty rule, add comment:

1. run phpmd: ``$ composer phpmd-xml``
2. look at rule name
3. add string ``@SuppressWarnings("rule name")`` to phpdoc block of method or class

```
/**
 * Class Title
 *
 * ..
 * @SuppressWarnings("ElseExpression")
 * ..
 */
```

