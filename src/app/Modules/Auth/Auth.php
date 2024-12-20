<?php

namespace Picrab\Modules\Auth;

use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Core\Context;

class Auth implements ModuleInterface
{
    protected $context;
    private $loginPageId = 3;
    private $adminMainPageId = 4;
    private $action;
    private $pageId;
    private $error = null;

    public function __construct($db)
    {

    }

    public function setContext(Context $context): void
    {
        $this->context = $context;
    }

    public function render($renderModule = null, $params = [])
    {

    }


    private function isAuthenticated(): bool
    {
        return !empty($_SESSION['auth_user_id']);
    }

    public function logoutAuthLink($renderModule = null, $params = [])
    {
        $view = $this->isAuthenticated() ? 'logout' : 'profile';
        $template = $this->context->renderer->getThemePath() . "/modules/auth/" . $view . ".php";
        return $this->context->renderer->renderTemplate($template, []);
    }
}