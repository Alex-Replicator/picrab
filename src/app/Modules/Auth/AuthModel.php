<?php
namespace Picrab\Modules\Auth;
use Picrab\Components\Database\Database;
class AuthModel{

    private Database $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function authorize($post)
    {

    }

}