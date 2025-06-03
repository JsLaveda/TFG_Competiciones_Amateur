<?php
class User {
    private $db;

    public function __construct() {
        $this->db = SPDO::singleton();
    }

    public function save($nombre, $email, $password, $deporte) {
        $sql = "INSERT INTO usuarios (nombre, email, password, deporte) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$nombre, $email, $hash, $deporte]);
    }
}
?>
