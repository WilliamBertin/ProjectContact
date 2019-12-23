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

/* add.html.twig */
class __TwigTemplate_47bbae43baf532043caae8243d091ab4a2400335a2066a6cd77c101c4ac63a9b extends Template
{
    private $source;
    private $macros = [];

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
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "add.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "add.html.twig"));

        // line 1
        echo "<div class=\"form-add-contact-container\">

\t<div class=\"form-add-contact-container__addIcon addIcon\" id=\"add-contact\"></div>
\t<div class=\"form-add-contact-container__addIcon-title\">Ajouter un contact</div>
</div>

<div class=\"form-add-contact-container__form\" id=\"add-form\">
";
        // line 8
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["form"] ?? null), 'form_start');
        echo "

    <div class=\"form-field\">
        ";
        // line 11
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "firstname", [], "any", false, false, false, 11), 'widget');
        echo " 
    </div>
    <div class=\"form-field\">
        ";
        // line 14
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "lastname", [], "any", false, false, false, 14), 'widget');
        echo "
    </div>
    <div class=\"form-field\">
        ";
        // line 17
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "fullname", [], "any", false, false, false, 17), 'widget');
        echo "
        ";
        // line 18
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "fullname", [], "any", false, false, false, 18), 'errors');
        echo "
    </div>
    <div class=\"form-field\">
        ";
        // line 21
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "email", [], "any", false, false, false, 21), 'widget');
        echo "
        ";
        // line 22
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "email", [], "any", false, false, false, 22), 'errors');
        echo "
    </div>

    <button id=\"#addForm-submit\" type=\"submit\" value=\"Ajouter\" class=\"button-base\">Ajouter</button>

";
        // line 27
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["form"] ?? null), 'form_end');
        echo "

</div>
<div class=\"button\"></div>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "add.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  92 => 27,  84 => 22,  80 => 21,  74 => 18,  70 => 17,  64 => 14,  58 => 11,  52 => 8,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"form-add-contact-container\">

\t<div class=\"form-add-contact-container__addIcon addIcon\" id=\"add-contact\"></div>
\t<div class=\"form-add-contact-container__addIcon-title\">Ajouter un contact</div>
</div>

<div class=\"form-add-contact-container__form\" id=\"add-form\">
{{ form_start(form) }}

    <div class=\"form-field\">
        {{ form_widget(form.firstname) }} 
    </div>
    <div class=\"form-field\">
        {{ form_widget(form.lastname) }}
    </div>
    <div class=\"form-field\">
        {{ form_widget(form.fullname) }}
        {{ form_errors(form.fullname) }}
    </div>
    <div class=\"form-field\">
        {{ form_widget(form.email) }}
        {{ form_errors(form.email) }}
    </div>

    <button id=\"#addForm-submit\" type=\"submit\" value=\"Ajouter\" class=\"button-base\">Ajouter</button>

{{ form_end(form) }}

</div>
<div class=\"button\"></div>", "add.html.twig", "C:\\Users\\willi\\Desktop\\Symfony\\Project\\templates\\add.html.twig");
    }
}
