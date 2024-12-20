<?php
namespace Picrab\Modules\Meta;
use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Core\Context;

class Meta implements ModuleInterface {
    protected $context;

    public function __construct($db) {
    }

    public function setContext(Context $context): void {
        $this->context = $context;
    }

    public function render($renderModule = null, $params = []) {
        $template = $this->context->renderer->getThemePath() . "/modules/meta/meta.php";
        return $this->context->renderer->renderTemplate($template, [
            'renderModule' => $renderModule,
            'pageContent' => $this->context->pageContent,
            'db' => $this->context->db,
            'modules' => $this->context->modules ]);
    }

    public function footer($renderModule = null, $params = []) {
        $template = $this->context->renderer->getThemePath() . "/modules/meta/footer.php";
        return $this->context->renderer->renderTemplate($template, [
            'renderModule' => $renderModule,
            'pageContent' => $this->context->pageContent,
            'db' => $this->context->db,
            'modules' => $this->context->modules ]);
    }
}