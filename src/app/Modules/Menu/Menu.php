<?php
namespace Picrab\Modules\Menu;

class Menu
{
    public function render($renderer)
    {
        $template = $renderer->getThemePath() . "/modules/menu/menu.php";
        return $renderer->renderTemplate($template, []);
    }
}