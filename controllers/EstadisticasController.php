<?php
require_once 'models/Competicion.php';

class EstadisticasController {
    public function estadisticasFutbol() {
        $vista = new View();
        $vista->show("estadisticas_futbol.php");
    }

    public function verCompeticionesFutbol() {
        $modelo = new Competicion();
        $competiciones = $modelo->getCompeticionesFutbol();

        $vista = new View();
        $vista->show("competiciones_futbol.php", ['competiciones' => $competiciones]);
    }

    public function verPartidosFutbol() {
        // Aquí irá la lógica para partidos, más adelante.
    }
}
