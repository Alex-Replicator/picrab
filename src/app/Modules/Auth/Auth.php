<?php
namespace Picrab\Modules\Auth;

use Picrab\Components\ModulesManager\ModuleInterface;

class Auth implements ModuleInterface {
    private $renderer;
    private $renderModule;
    private $params;
    private $model;
    private $config;
    private $error;
    private $check;

    public function render($renderer, $renderModule, $params) {
        $this->renderer = $renderer;
        $this->renderModule = $renderModule;
        $this->params = $params;
        $this->error = null;
        $this->model = new AuthModel($this->params['db']);
        $this->config = [
            'adminPageTypes' => [3, 5],
            'loginPage' => 3,
            'adminMainPage' => 4
        ];
        $this->check = $this->checkAuth();
        $view = $this->resolveView();
        $template = $this->renderer->getThemePath() . "/modules/auth/" . $view . ".php";
        return $this->renderer->renderTemplate($template, [
            'renderModule' => $this->renderModule,
            'error' => $this->error
        ]);
    }

    private function resolveView() {
        $id = $this->params['pageContent']['id'];
        $action = $this->params['pageContent']['action'];
        if ($action === 'logout') {
            $this->logout($id);
        }
        if (($this->check == 0) && ($id != $this->config['loginPage'])) {
            header("Location: index.php?id=" . $this->config['loginPage']);
            exit;
        }
        if (($this->check == 0) && ($id == $this->config['loginPage'])) {
            if ($action === 'login' && !empty($_POST)) {
                $this->error = $this->model->authorize($_POST);
            }
            return 'loginform';
        }
        if (($this->check != 0) && ($id == $this->config['loginPage'])) {
            header("Location: index.php?id=" . $this->config['adminMainPage']);
            exit;
        }
        if (($this->check != 0) && ($id != $this->config['loginPage'])) {
            return "admin";
        }
        return "loginform";
    }

    public function checkAuth() {
        if (empty($_SESSION) || !isset($_SESSION['auth_user_id']) || !is_int($_SESSION['auth_user_id'])) {
            return 0;
        }

        return $_SESSION['auth_user_id'];
    }

    public function logout($id) {
        if (isset($_SESSION['auth_user_id']) && is_numeric($_SESSION['auth_user_id'])) {
            session_unset();
            session_destroy();
            header("Location: index.php?id=" . $id);
            exit;
        }
    }

    public function logoutAuthLink($renderer, $renderModule, $params) {
        $this->renderer = $renderer;
        $this->renderModule = $renderModule;
        $this->params = $params;
        $this->check = $this->checkAuth();
        if($this->check == 0){
            $view = 'enter';
        }
        else{
            $view = 'logout';
        }
        $template = $this->renderer->getThemePath() . "/modules/auth/" . $view . ".php";
        return $this->renderer->renderTemplate($template, []);
    }

}
