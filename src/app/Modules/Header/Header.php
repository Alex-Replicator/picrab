<?php
namespace Picrab\Modules\Header;

class Header
{
    public function render($renderer)
    {
        __dd($renderer);
        $template = $renderer->getThemePath() . "/modules/header/header.php";
        return $renderer->renderTemplate($template, [
            'renderModule' => $renderModule
        ]);

    }
}