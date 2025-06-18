<?php

require_once 'models/EquipoModel.php';

class EquipoController
{
    public function crearEquipo()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?controlador=usuario&accion=login");
            exit();
        }

        $vista = new View();

        // Mostrar formulario
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id_competicion = $_GET['competicion_id'] ?? null;
            if (!$id_competicion) {
                echo "Error: No se encontró el ID de la competición.";
                return;
            }

            // Obtener equipos existentes
            $equipoModel = new EquipoModel();
            $equiposExistentes = $equipoModel->obtenerPorCompeticion($id_competicion);

            $vista->show('crearEquipo.php', [
                'competicion_id' => $id_competicion,
                'equiposExistentes' => $equiposExistentes
            ]);
            return;
        }

        // Procesar formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_competicion = $_GET['competicion_id'] ?? $_POST['competicion_id'] ?? null;
            $nombres = $_POST['equipos'] ?? [];

            if (!$id_competicion || count($nombres) < 2) {
                header("Location: index.php?controlador=equipo&accion=crearEquipo&competicion_id=$id_competicion&error=Introduce+al+menos+2+equipos");
                exit();
            }

            $nombresLimpios = array_map('trim', $nombres);
            if (count($nombresLimpios) !== count(array_unique(array_map('strtolower', $nombresLimpios)))) {
                header("Location: index.php?controlador=equipo&accion=crearEquipo&competicion_id=$id_competicion&error=Hay+equipos+repetidos");
                exit();
            }

            foreach ($nombresLimpios as $nombre) {
                $equipo = new EquipoModel();
                $equipo->setNombre($nombre);
                $equipo->setId_competicion($id_competicion);
                $equipo->save();
            }

            header("Location: index.php?controlador=competicion&accion=verCompeticion&id=$id_competicion");
            exit();
        }
    }

    public function verEquipo()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $equipoModel = new EquipoModel();
        $equipos = [];

        // $obtenerEquipos = $equipoModel->getEquiposYJugadores(); // Descomenta si lo usas

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

    // Eliminar equipo
public function eliminarEquipo()
{
    if (session_status() == PHP_SESSION_NONE) session_start();

    $id_equipo = $_GET['id_equipo'] ?? null;
    $competicion_id = $_GET['competicion_id'] ?? null;

    if (!$id_equipo || !$competicion_id) {
        echo "Error al eliminar el equipo.";
        return;
    }

    $equipo = new EquipoModel();
    $equipo->setId_equipo($id_equipo);
    $equipo->delete();

    header("Location: index.php?controlador=equipo&accion=crearEquipo&competicion_id=$competicion_id&success=Equipo eliminado");
    exit();
}

// Mostrar formulario para editar equipo
public function editarEquipo()
{
    if (session_status() == PHP_SESSION_NONE) session_start();

    $id_equipo = $_GET['id_equipo'] ?? null;
    $competicion_id = $_GET['competicion_id'] ?? null;

    if (!$id_equipo || !$competicion_id) {
        echo "Datos no válidos.";
        return;
    }

    $equipo = new EquipoModel();
    $equipo = $equipo->obtenerPorId($id_equipo);

    $vista = new View();
    $vista->show('editarEquipo.php', [
        'equipo' => $equipo,
        'competicion_id' => $competicion_id
    ]);
}

// Guardar edición
public function guardarEdicion()
{
    if (session_status() == PHP_SESSION_NONE) session_start();

    $id_equipo = $_POST['id_equipo'] ?? null;
    $competicion_id = $_POST['competicion_id'] ?? null;
    $nuevoNombre = trim($_POST['nombre'] ?? '');

    if (!$id_equipo || !$competicion_id || !$nuevoNombre) {
        echo "Datos inválidos";
        return;
    }

    $equipo = new EquipoModel();
    $equipo->setId_equipo($id_equipo);
    $equipo->setNombre($nuevoNombre);
    $equipo->update(); 

    header("Location: index.php?controlador=equipo&accion=crearEquipo&competicion_id=$competicion_id&success=Equipo+modificado");
    exit();
}

}
