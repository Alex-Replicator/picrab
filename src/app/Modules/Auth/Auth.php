<?php
namespace Picrab\Modules\Auth;
use Picrab\Components\ModulesManager\ModuleInterface;

class Auth implements ModuleInterface
{

    private string $view = 'dashboard';
    private $renderer;
    private $renderModule;
    private array $params;
    private $model;
    private array $config;
    private $error;
    private $check;



    public function render($renderer, $renderModule, $params)
    {
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
        $this->authDispatch();
        return $this->renderAuthPage();
    }

    private function authDispatch(): void
    {

        if($this->params['pageContent']['action'] === 'logout'){
            $this->logout($this->params['pageContent']['id']);
        }

        if(($this->check == 0) && ($this->params['pageContent']['id'] != $this->config['loginPage'])){
            header("Location: index.php?id=".$this->config['loginPage']);
            exit;
        }

        if(($this->check == 0) && ($this->params['pageContent']['id'] == $this->config['loginPage'])){
            $this->view = 'loginform';
            if($this->params['pageContent']['action'] === 'login' && !empty($_POST)){
                $this->error = $this->model->authorize($_POST);
            }
        }

        if(($this->check != 0) && ($this->params['pageContent']['id'] == $this->config['loginPage'])){
            header("Location: index.php?id=".$this->config['adminMainPage']);
            exit;
        }

        if(($this->check != 0) && ($this->params['pageContent']['id'] != $this->config['loginPage'])){
            $this->view = "admin";
        }
    }

    public function checkAuth(): bool|int
    {

        if (empty($_SESSION) || !is_int($_SESSION['auth_user_id']) || !isset($_SESSION['auth_user_id'])) {
            return 0;
        }

        return $_SESSION['auth_user_id'];
    }

    public function logout($id): void
    {
        if (!empty($_SESSION) && isset($_SESSION['auth_user_id']) && is_numeric($_SESSION['auth_user_id'])) {
            session_unset();
            session_destroy();
            header("Location: index.php?id=" . $id);
            exit;
        }
    }


    private function renderAuthPage()
    {
        $template = $this->renderer->getThemePath()."/modules/auth/{$this->view}.php";
        return $this->renderer->renderTemplate($template, [
            'renderModule' => $this->renderModule
        ]);
    }

}