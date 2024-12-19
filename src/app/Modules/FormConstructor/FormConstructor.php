<?php
namespace Picrab\Modules\FormConstructor;

use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Components\FormConstructor\FormConstructor as FC;

class FormConstructor implements ModuleInterface {
    private $renderer;
    private $renderModule;
    private $params;
    private $formConstructor;

    public function __construct($db) {
        $this->formConstructor = new FC($db);
    }

    public function render($renderer, $renderModule, $params) {
        $this->renderer = $renderer;
        $this->renderModule = $renderModule;
        $this->params = $params;

        $pageId = $this->params['pageContent']['id'];
        $pageTypeId = $this->params['pageContent']['pageTypeID'];
        $fieldsData = $this->formConstructor->getFieldsForPage($pageId, $pageTypeId);
        $template = $this->renderer->getThemePath() . "/modules/formconstructor/form.php";

        return $renderer->renderTemplate($template, [
            'fieldsData' => $fieldsData,
            'renderModule' => $renderModule,
            'pageContent' => $params['pageContent'] ?? [], 'db' => $params['db'] ?? null
        ]);
    }

    public function save($pageId, $data) {
        $this->formConstructor->saveFields($pageId, $data);
    }
}
