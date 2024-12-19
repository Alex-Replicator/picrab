<?php
namespace Picrab\Modules\Auth;

use Picrab\Components\Database\Database;

class AuthModel {
    private Database $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function authorize($post) {
        $username = $post['username'] ?? '';
        $password = $post['password'] ?? '';
        $res = $this->db->query("SELECT * FROM hGtv_users WHERE username=? LIMIT 1", [$username]);
        if (!$res) {
            return "Неверный логин или пароль";
        }
        $user = $res[0];
        if (!password_verify($password, $user['password'])) {
            return "Неверный логин или пароль";
        }
        $_SESSION['auth_user_id'] = (int)$user['id'];
        header("Location: index.php?id=4");
        exit;
    }
}
