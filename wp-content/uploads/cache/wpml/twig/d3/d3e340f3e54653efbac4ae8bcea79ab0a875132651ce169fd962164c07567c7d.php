<?php

/* translation-priority-select.twig */
class __TwigTemplate_92e3f9e9af7f50e864d11ddf7088b5ecd6e7c4c928982ffab01db515710eca34 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<select  class=\"wpml-select2-button js-change-translation-priority\" id=\"icl-st-change-translation-priority-selected\" disabled=\"disabled\">
    <option value=\"\">";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "empty_text", array()));
        echo "</option>
    ";
        // line 3
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["translation_priorities"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["translation_priority"]) {
            // line 4
            echo "        <option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["translation_priority"], "name", array()), "html", null, true);
            echo "\">
            ";
            // line 5
            echo twig_escape_filter($this->env, $this->getAttribute($context["translation_priority"], "name", array()), "html", null, true);
            echo "
        </option>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['translation_priority'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 8
        echo "</select>

";
        // line 10
        echo ($context["nonce"] ?? null);
    }

    public function getTemplateName()
    {
        return "translation-priority-select.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 10,  44 => 8,  35 => 5,  30 => 4,  26 => 3,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "translation-priority-select.twig", "/var/www/vhosts/hoverex.themerex.net/httpdocs/wp-content/plugins/wpml-string-translation/templates/translation-priority/translation-priority-select.twig");
    }
}
