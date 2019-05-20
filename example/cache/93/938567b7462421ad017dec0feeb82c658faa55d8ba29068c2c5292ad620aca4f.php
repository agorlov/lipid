<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* index.twig */
class __TwigTemplate_1b324295e20213a66b530883f8dad51ae5e66a6427b86e8f2a3291ca1a1c099a extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 2
        echo "<h1>Hello, World!</h1>

<p>Now is: ";
        // line 4
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["date"] ?? null), "format", [0 => "d.m.Y H:i:s"], "method", false, false, false, 4), "html", null, true);
        echo "</p>
<p>_GET['test']: ";
        // line 5
        echo twig_escape_filter($this->env, ($context["test"] ?? null), "html", null, true);
        echo "</p>

<p>You could <a href=\"/login\">login</a>.</p>";
    }

    public function getTemplateName()
    {
        return "index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  43 => 5,  39 => 4,  35 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("{# First Template #}
<h1>Hello, World!</h1>

<p>Now is: {{date.format('d.m.Y H:i:s')}}</p>
<p>_GET['test']: {{test}}</p>

<p>You could <a href=\"/login\">login</a>.</p>", "index.twig", "/home/alexandr/ObjectMVC/example/tpl/index.twig");
    }
}
