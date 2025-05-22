<?php
class User {
    private $db;

    public function __construct() {
        $this->db = SPDO::singleton();
    }

    public function save($nombre_usuario, $nombre, $email, $contraseña_hash) {
        $sql = "INSERT INTO usuario (nombre_usuario, nombre, email, contraseña) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre_usuario, $nombre, $email, $contraseña_hash]);
    }

    public function verificarLogin($nombre_usuario, $contraseña) {
    $stmt = $this->db->prepare("SELECT * FROM usuario WHERE nombre_usuario = ?");
    $stmt->execute([$nombre_usuario]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
        return $usuario;
    } else {
        return false;
    }
}

}
?>
