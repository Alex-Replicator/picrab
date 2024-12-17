<?php
namespace Picrab\Modules\Menu;

use Picrab\Components\ModulesManager\ModuleInterface;

class Menu implements ModuleInterface
{
    public function render($renderer, $renderModule, $params)
    {
        $template = $renderer->getThemePath()."/modules/menu/menu.php";
        return $renderer->renderTemplate($template, [
            'renderModule' => $renderModule
        ]);
    }

    public function item($renderer, $renderModule, $params){
        $template = $renderer->getThemePath()."/modules/menu/item.php";
        return $renderer->renderTemplate($template, []);
    }

}