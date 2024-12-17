<?php
namespace Picrab\Modules\Footer;
use Picrab\Components\ModulesManager\ModuleInterface;

class Footer implements ModuleInterface
{
    public function render($renderer, $renderModule)
    {
        $template = $renderer->getThemePath()."/modules/footer/footer.php";
        return $renderer->renderTemplate($template, [
            'renderModule' => $renderModule
        ]);
    }
}