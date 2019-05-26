<?php

namespace ExampleApp;

use Exception;
use Lipid\Tpl;
use Lipid\Tpl\Twig;
use Lipid\Request\RqENV;

final class AppTwig implements Tpl
{
    
    private $tpl;
    private $env;
    private $tplName;

    public function __construct(string $tplName, Tpl $tpl = null, Request $ENV = null)
    {
        $this->tplName = $tplName;
        $this->tpl = $tpl;
        $this->env = $ENV ?? new RqENV();
    }

    private function tpl(): Tpl
    {
        if (! is_null($this->tpl)) {
            return $this->tpl;
        }

        try {
            $debug = (boolean) $this->env->param('APP_DEBUG');
        } catch (Exception $e) {
            $debug = true;
        }

        return new Twig(
            $this->tplName,
            new \Twig\Environment(
                new \Twig\Loader\FilesystemLoader(
                    __DIR__ . '/tpl'
                ),
                [
                    'cache' => __DIR__ . '/cache',
                    'debug' =>  $debug
                ]
            )
        );
    }

    public function render(array $data = null): string
    {
        return $this->tpl()->render($data);
    }
}
