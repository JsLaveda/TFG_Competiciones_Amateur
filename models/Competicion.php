<?php
class Competicion {
    public function getCompeticionesFutbol() {
        $conexion = SPDO::singleton();
        $stmt = $conexion->prepare("SELECT * FROM competicion WHERE tipo_competicion = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
