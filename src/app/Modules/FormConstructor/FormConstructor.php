<?php
namespace Picrab\Modules\FormConstructor;

use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Core\Context;
use Picrab\Components\FormConstructor\FormConstructor as FC;

class FormConstructor implements ModuleInterface {
    protected $context;
    private $formConstructor;

    public function __construct($db) {
        $this->formConstructor = new FC($db);
    }

    public function setContext(Context $context): void {
        $this->context = $context;
    }

    public function render($renderModule = null, $params = []) {
        $pageId = $this->context->pageContent['id'];
        $pageTypeId = $this->context->pageContent['pageTypeID'];
        $fieldsData = $this->formConstructor->getFieldsForPage($pageId, $pageTypeId);
        $template = $this->context->renderer->getThemePath() . "/modules/formconstructor/form.php";
        return $this->context->renderer->renderTemplate($template, [
            'fieldsData' => $fieldsData,
            'renderModule' => $renderModule,
            'pageContent' => $this->context->pageContent,
            'db' => $this->context->db,
            'modules' => $this->context->modules ]);
    }

    public function save($pageId, $data) {
        $this->formConstructor->saveFields($pageId, $data);
    }
}