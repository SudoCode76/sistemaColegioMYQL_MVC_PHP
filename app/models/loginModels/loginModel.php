<?php
require_once __DIR__ . '/../../config/conexion.php';

class LoginModel {
    private $conn;

    public function __construct(){
        global $conexion;
        $this->conn = $conexion;
    }

    public function login($nombreUsuario, $contrasenia){
        $sql = "SELECT u.*, r.nombre AS nombreRol FROM USUARIO u JOIN ROL r ON u.codRol = r.codRol WHERE u.nombreUsuario = ? AND u.contrasenia = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $nombreUsuario, $contrasenia);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
}
?>
