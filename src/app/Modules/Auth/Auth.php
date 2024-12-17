<?php
namespace Picrab\Modules\Auth;
use Picrab\Components\ModulesManager\ModuleInterface;

class Auth implements ModuleInterface
{
    public function render($renderer, $renderModule)
    {
        $template = $renderer->getThemePath()."/modules/auth/auth.php";
        return $renderer->renderTemplate($template, [
            'renderModule' => $renderModule
        ]);
    }
}