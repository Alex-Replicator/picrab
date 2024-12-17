<?php
namespace Picrab\Modules\Header;

use Picrab\Components\ModulesManager\ModuleInterface;

class Header implements ModuleInterface
{
    public function render($renderer, $renderModule, $params)
    {
        $template = $renderer->getThemePath()."/modules/header/header.php";
        return $renderer->renderTemplate($template, [
            'renderModule' => $renderModule
        ]);
    }
}