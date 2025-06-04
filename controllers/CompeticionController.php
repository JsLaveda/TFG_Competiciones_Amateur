<?php
require_once 'models/CompeticionModel.php';
require_once 'models/EquipoModel.php';
require_once 'models/PartidoModel.php';

class CompeticionController
{
    public function index()
    {
        $vista = new View();
        $vista->show("competicion.php");
    }

    public function crearCompeticion() {}

    public function clasificacion() //Sin terminar
    {
        $competicion = new CompeticionModel();
        $equipos = $competicion->obtenerEquipos(); // Array de objetos EquipoModel


        $clasificacion = [];

        foreach ($equipos as $equipo) {
            $id = $equipo->getId_equipo();
            $clasificacion[$id] = ['nombre' => $equipo->getNombre(),'puntos' => 0 ];
        }

        // Procesar cada partido
        foreach ($partidos as $partido) {
            $idEq1 = $partido->getEquipo1();
            $idEq2 = $partido->getEquipo2();
            $p1 = $partido->getPuntuacion1();
            $p2 = $partido->getPuntuacion2();

            if (!isset($clasificacion[$idEq1]) || !isset($clasificacion[$idEq2])) {
                // Evitar errores si algún equipo no está registrado
                continue;
            }

            if ($p1 > $p2) {
                $clasificacion[$idEq1]['puntos'] += 3;
            } elseif ($p1 < $p2) {
                $clasificacion[$idEq2]['puntos'] += 3;
            } else {
                $clasificacion[$idEq1]['puntos'] += 1;
                $clasificacion[$idEq2]['puntos'] += 1;
            }
        }

        // Ordenar por puntos descendentes
        usort($clasificacion, function ($a, $b) {
            return $b['puntos'] <=> $a['puntos'];
        });

        // Mostrar en vista
        $vista = new View();
        $vista->show("clasificacion.php", ['clasificacion' => $clasificacion]);
    }
}
