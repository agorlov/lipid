<?php

namespace Lipid\Tpl;

use Lipid\Tpl;

final class Twig implements Tpl
{

    private $twig;
    private $tplName;

    /**
     * Constructor.
     *
     * @param string $tplName template file name
     * @param string|\Twig\Environment $tplPath directory with templates
     */
    public function __construct(string $tplName, $tplPath)
    {
        $this->tplName = $tplName;
        if ($tplPath instanceof \Twig\Environment) {
            $this->twig = $tplPath;
        } elseif (is_string($tplPath)) {
            $this->twig = new \Twig\Environment(
                new \Twig\Loader\FilesystemLoader($tplPath),
                [
                    //'cache' => '/path/to/compilation_cache',
                ]
            );
        } else {
            throw new \Exception("\$tplPath must be string or \Twig\Environment." . print_r($tplPath, true));
        }
    }

    public function render(array $tplData = null): string
    {
        return $this->twig->render($this->tplName, $tplData);
    }
}
