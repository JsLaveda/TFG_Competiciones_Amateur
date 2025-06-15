<?php

require_once 'model/EquipoModel.php';

class EquipoController
{
    public function crearEquipo()
    {
        $vista = new View();

        // Mostrar formulario
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id_competicion = $_GET['competicion_id'] ?? null;
            if (!$id_competicion) {
                echo "Error: No se encontró el ID de la competición.";
                return;
            }

            $vista->show('crearEquipo.php', [
                'competicion_id' => $id_competicion
            ]);
        }

        // Procesar formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_competicion = $_GET['competicion_id'] ?? null;
            $nombre = $_POST['nombre'] ?? null;

            if (!$id_competicion || !$nombre) {
                echo "Error: Datos incompletos.";
                return;
            }

            $equipo = new EquipoModel();
            $equipo->setNombre($nombre);
            $equipo->setId_competicion($id_competicion);
            $equipo->save();

            // Redirigir al mismo formulario para seguir creando
            header("Location: index.php?controller=equipo&action=crear&competicion_id=$id_competicion");
            exit();
        }
    }

    public function verEquipo()
    {
        $equipoModel = new EquipoModel();
        $obtenerEquipos = $equipoModel->getEquiposYJugadores();

        $equipos = [];
        foreach ($obtenerEquipos as $fila) {
            $nombre_equipo = $fila['nombre_equipo'];
            if (!isset($equipos[$nombre_equipo])) {
                $equipos[$nombre_equipo] = [];
            }

            if (!empty($fila['nombre_jugador'])) {
                $equipos[$nombre_equipo][] = $fila['nombre_jugador'];
            }
        }

        $vista = new View();
        $vista->show('verEquipos.php', ['equipos' => $equipos]);
    }
}
