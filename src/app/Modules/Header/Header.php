<?php
namespace Picrab\Modules\Header;

use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Core\Context;

class Header implements ModuleInterface
{

    protected $context;

    public function __construct($db)
    {
        // Конструктор можно оставить пустым }
    }

    public function setContext(Context $context): void
    {
        $this->context = $context;
    }

    public function render($renderModule = null, $params = [])
    {
        $template = $this->context->renderer->getThemePath() . "/modules/header/header.php";
        return $this->context->renderer->renderTemplate($template, [
            'renderModule' => $renderModule,
            'pageContent' => $this->context->pageContent,
            'db' => $this->context->db,
            'modules' => $this->context->modules]);
    }

}