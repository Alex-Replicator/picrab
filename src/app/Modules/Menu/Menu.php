<?php
namespace Picrab\Modules\Menu;

use Picrab\Components\ModulesManager\ModuleInterface;
use Picrab\Core\Context;

class Menu implements ModuleInterface
{
    protected $context;

    public function __construct($db)
    {
        // Конструктор оставляем пустым }
    }

    public function setContext(Context $context): void
    {
        $this->context = $context;
    }

    public function render($renderModule = null, $params = [])
    {
        $userId = $_SESSION['auth_user_id'] ?? 0;
        $userInfo = null;
        if ($userId > 0) {
            $res = $this->context->db->query("SELECT username FROM `hGtv_users` WHERE id=? LIMIT 1", [$userId]);
            if ($res) {
                $userInfo = $res[0];
            }
        }

        $template = $this->context->renderer->getThemePath() . "/modules/menu/menu.php";
        return $this->context->renderer->renderTemplate($template, [
            'userInfo' => $userInfo]);
    }
}