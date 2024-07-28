<?php
require_once __DIR__ . '/../../models/loginModels/loginModel.php';

class LoginController {
    private $model;

    public function __construct(){
        $this->model = new LoginModel();
    }

    public function login($nombreUsuario, $contrasenia){
        return $this->model->login($nombreUsuario, $contrasenia);
    }
}
?>