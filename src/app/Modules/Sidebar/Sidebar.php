<?php
namespace Picrab\Modules\Sidebar;

use Picrab\Components\ModulesManager\ModuleInterface;

class Sidebar implements ModuleInterface {
    public function render($renderer, $renderModule, $params) {
        $template = $renderer->getThemePath() . "/modules/sidebar/sidebar.php";
        return $renderer->renderTemplate($template, [
            'renderModule' => $renderModule,
            'pageContent' => $params['pageContent'] ?? [],
            'db' => $params['db'] ?? null
        ]);
    }
}