<?php
namespace Picrab\Modules\Footer;

class Footer
{
    public function render($renderer)
    {
        $template = $renderer->getThemePath() . "/modules/footer/footer.php";
        return $renderer->renderTemplate($template, []);
    }
}