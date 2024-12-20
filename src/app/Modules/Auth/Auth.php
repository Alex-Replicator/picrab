<?php

namespace Picrab\Modules\Auth;

use Dotenv\Loader\Loader;
use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Core\Context;

class Auth implements ModuleInterface
{
    protected $context;
    private $loginPageId = 3;
    private $adminMainPageId = 4;

    private $action;
    private $pageId;

    private $authCheck;

    private $user = null;

    private $pageType;

    private $error = null;

    private array $denied;

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        if($this->isAuthenticated()){
            $this->getUser($this->isAuthenticated());
        }
    }

    public function setConfig()
    {
        $this->authCheck = $this->isAuthenticated();
        $this->action = $this->context->renderer->globalConfig['current_page']['action'];
        $this->pageType = $this->context->renderer->globalConfig['current_page']['pageTypeID'];
        $this->pageId = $this->context->renderer->globalConfig['current_page']['pageContent']['id'];
        $this->denied = [3, 5];
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
        if(!empty($_SESSION['auth_user_id']) && is_int($_SESSION['auth_user_id'])){
            return $_SESSION['auth_user_id'];
        }

        return false;
    }

    public function logoutAuthLink($renderModule = null, $params = [])
    {
        $this->dispatch();
        $view = $this->authCheck ? 'logout' : 'profile';
        $template = $this->context->renderer->getThemePath() . "/modules/auth/" . $view . ".php";
        return $this->context->renderer->renderTemplate($template, ['user' => $this->user]);
    }

    public function loginForm($renderModule = null, $params = []){
        $this->dispatch();
        $params = ['error' => $this->error];
        $template = $this->context->renderer->getThemePath() . "/modules/auth/loginform.php";
        return $this->context->renderer->renderTemplate($template, $params);
    }

    private function getUser($id)
    {
        $res = $this->db->query("SElECT * FROM `hGtv_users` WHERE `id` = ? LIMIT 1", [$id]);
        if(!empty($res)){
            $this->user = [
                'id' => $res[0]['id'],
                'login' => $res[0]['username']
            ];
            return true;
        }
        return false;
    }

    public function dispatch()
    {
        $this->setConfig();

        if(($this->action == "logout") && ($this->authCheck)){
            $_SESSION = [];
            session_destroy();
            header("Location: index.php?id=".$this->pageId);
            exit();
        }

        if($this->action === 'login' && !$this->authCheck && isset($_POST['username'], $_POST['password'])){
            $password = sanitaze($_POST['password']);
            $username = sanitaze($_POST['username']);
            $res = $this->db->query("SElECT * FROM `hGtv_users` WHERE `username` = ? LIMIT 1", [$username]);
            if(empty($res) || !$res){
                $this->error = 'Пользователя с таким логином не существует';
            }
            if(!empty($res) && $res){
                $dbPassword = $res[0]['password'];
                if(password_verify($password, $dbPassword)){
                    $_SESSION['auth_user_id'] = $res[0]['id'];
                    header("Location: index.php?id=".$this->adminMainPageId);
                    exit;
                }
                else{
                    $this->error = 'Неправильный пароль';
                }
            }
        }

        if(!$this->authCheck && in_array($this->pageType, $this->denied)){
            header("Location: index.php?id=".$this->loginPageId);
            exit;
        }

        if($this->authCheck && ($this->pageId == $this->loginPageId)){
            header("Location: index.php?id=".$this->adminMainPageId);
            exit;
        }


    }

}