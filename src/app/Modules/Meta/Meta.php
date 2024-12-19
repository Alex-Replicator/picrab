<?php
namespace Picrab\Modules\Meta;

use Picrab\Components\ModulesManager\ModuleInterface;

class Meta implements ModuleInterface {
    public function render($renderer, $renderModule, $params) {
        $template = $renderer->getThemePath() . "/modules/meta/meta.php";
        return $renderer->renderTemplate($template, [
            'renderModule' => $renderModule,
            'pageContent' => $params['pageContent'] ?? [],
            'db' => $params['db'] ?? null
        ]);
    }

    public function footer($renderer, $renderModule, $params) {
        $template = $renderer->getThemePath() . "/modules/meta/footer.php";
        return $renderer->renderTemplate($template, [
            'renderModule' => $renderModule,
            'pageContent' => $params['pageContent'] ?? [],
            'db' => $params['db'] ?? null
        ]);
    }
}