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

/* home.html.twig */
class __TwigTemplate_dc13d75b6460586611f9a6ecec4bafb3c5d149f50b4a2aacef471ddd71d96fde extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'stylesheet' => [$this, 'block_stylesheet'],
            'nav' => [$this, 'block_nav'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
<html lang=\"fr\">
    <head>
        <meta charset=\"utf-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <title>";
        // line 6
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <link rel=\"icon\" href=\"\">
        ";
        // line 8
        $this->displayBlock('stylesheet', $context, $blocks);
        // line 13
        echo "    </head>

    <body>
        ";
        // line 16
        $this->displayBlock('nav', $context, $blocks);
        // line 26
        echo "
        <div class=\"container-fluid\">
            ";
        // line 28
        $this->displayBlock('content', $context, $blocks);
        // line 31
        echo "
        </div>

    </body>
</html>






";
    }

    // line 6
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 8
    public function block_stylesheet($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 9
        echo "            <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css\" integrity=\"sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T\" crossorigin=\"anonymous\">

            <link rel=\"stylesheet\" href=\"\">
        ";
    }

    // line 16
    public function block_nav($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 17
        echo "        <div class=\"row justify-content-end align-items-center pt-3\">
                            <div class=\"offset-1 offset-xl-2 col text-center\">
                                <a href=\"index\" title=\"Accueil\" class=\"h6 font-weight-bold\">Accueil</a>
                            </div>
                            <div class=\"col text-center\">
                                <a href='whoIam.html.twig' title=\"whoIam\" class=\"h6 font-weight-bold\">Qui je suis</a>
                            </div>
                             
        ";
    }

    // line 28
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 29
        echo "                test
            ";
    }

    public function getTemplateName()
    {
        return "home.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  120 => 29,  116 => 28,  104 => 17,  100 => 16,  93 => 9,  89 => 8,  83 => 6,  68 => 31,  66 => 28,  62 => 26,  60 => 16,  55 => 13,  53 => 8,  48 => 6,  41 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!doctype html>
<html lang=\"fr\">
    <head>
        <meta charset=\"utf-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <title>{% block title %}{% endblock %}</title>
        <link rel=\"icon\" href=\"\">
        {% block stylesheet %}
            <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css\" integrity=\"sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T\" crossorigin=\"anonymous\">

            <link rel=\"stylesheet\" href=\"\">
        {% endblock %}
    </head>

    <body>
        {% block nav  %}
        <div class=\"row justify-content-end align-items-center pt-3\">
                            <div class=\"offset-1 offset-xl-2 col text-center\">
                                <a href=\"index\" title=\"Accueil\" class=\"h6 font-weight-bold\">Accueil</a>
                            </div>
                            <div class=\"col text-center\">
                                <a href='whoIam.html.twig' title=\"whoIam\" class=\"h6 font-weight-bold\">Qui je suis</a>
                            </div>
                             
        {% endblock %}

        <div class=\"container-fluid\">
            {% block content %}
                test
            {% endblock %}

        </div>

    </body>
</html>






", "home.html.twig", "/home/marie/OpenClassRooms/Projet5/Portfolio/src/View/home.html.twig");
    }
}
