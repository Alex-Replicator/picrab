<?php
namespace Picrab\Components\ModulesManager;

use Picrab\Core\Context;

interface ModuleInterface {
    public function setContext(Context $context): void;
    public function render($renderModule = null, $params = []);
}