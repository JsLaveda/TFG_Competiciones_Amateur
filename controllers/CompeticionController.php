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

    public function crearCompeticion()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Evitar cache 
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?controller=usuario&action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $privacidad = isset($_POST['privacidad']) ? 1 : 0;
            $tipo_competicion = $_POST['tipo_competicion'] ?? 'futbol';
            $creador = $_SESSION['usuario']['id'];

            $competicion = new CompeticionModel();
            $competicion->setNombre($nombre);
            $competicion->setPrivacidad($privacidad);
            $competicion->setTipo_competicion($tipo_competicion);
            $competicion->setCreador($creador);

            $idCompeticion = $competicion->save();

            header("Location: index.php?controller=equipo&action=crear&competicion_id=" . $idCompeticion); //Creacion equipos
            exit();
        } else {

            $vista = new View();
            $vista->show('crearCompeticion.php'); //Cambiar por vista competicion
        }
    }



    public function clasificacion()
    {
        if (!isset($_GET['id'])) {
            echo "Error: competicion no especificada"; //Cambiar por competicion no encontrada
            return;
        }
        //Obtener datos de la competicion
        $id = intval($_GET['id']);
        $competicionModel = new CompeticionModel();
        $competicion = $competicionModel->getById($id);
        //comprobar si la encuentra
        if (!$competicion) {
            header('Location: index.php?controller=competicion&action=index');
            exit();
        }
        //Si el estado está pendiente, mostrar pantalla de espera
        if ($competicion['estado'] === 'pendiente') {
            $vista = new View();
            $vista->show('competicionEnCreacion.php', ['competicion' => $competicion]);
            return;
        }
        //Obtener la classificacion
        $competicionModel->setId_competicion($id);
        $clasificacion = $competicionModel->getClasificacion();

        $vista = new View();
        $vista->show("", ['clasificacion' => $clasificacion, 'id_competicion' => $id]); //mostrar vista con clasificacion
    }

    public function inicioCompeticion()
    {

        $id = intval($_GET['id']);

        $competicion = new CompeticionModel();
        $competicion->setId_competicion($id);

        // Iniciar competición (cambia estado y fecha, y genera los partidos)
        $competicion->iniciarCompeticion();

        header("Location: index.php?controller=competicion&action=verCompeticion&id=$id");
        exit();
    }

    public function finCompeticion()
    {
        $id = intval($_GET['id']);

        $competicion = new CompeticionModel();
        $competicion->setId_competicion($id);

        // Finalizar la competición (cambiar estado y fecha)
        $competicion->finalizarCompeticion();

        header("Location: index.php?controller=competicion&action=verCompeticion&id=$id");
        exit();
    }

    public function borrarCompeticion()
    {
        $id = intval($_GET['id']);

        $competicion = new CompeticionModel();
        $competicion->setId_competicion($id);

        // Eliminar competición y dependencias
        $competicion->delete();

        header("Location: index.php?controller=competicion&action=index");
        exit();
    }



    public function verCompeticion() //Hay que modificarla añadiendo el parametro del estado de la competicion
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        //No acceso despues de caché
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        //id vacio o no se lo das
        $idCompeticion = $_GET['id'] ?? null;
        if (!$idCompeticion) {
            header('Location: index.php?controller=competicion&action=index'); //mostrar error competicion no encontrada
            exit();
        }

        //Obtener la competicion
        $competicionModel = new CompeticionModel();
        $competicion = $competicionModel->getById($idCompeticion);
        // competicion no existe en base de datos
        if (!$competicion) {
            header('Location: index.php?controller=competicion&action=index');
            exit();
        }

        // comprobar usuario es creador
        $usuarioActual = $_SESSION['usuario'];
        $esCreador = ($usuarioActual['id'] == $competicion['creador']);

        // comprobar si hay equipos
        $equipoModel = new EquipoModel();
        $cantidadEquipos = $equipoModel->contarEquiposPorCompeticion($idCompeticion);

        //comprobar estado competicion
        $estadoCompeticion = $competicion['estado'];

        if ($esCreador) {
            //es creador pero no hay suficientes equipos creados
            if ($cantidadEquipos < 2) {
                header("Location: index.php?controller=equipo&action=crear&competicion_id=$idCompeticion"); //mostrar creador equipos de esa competicion
                exit();
            } else {
                //es creador y hay suficientes equipos creados
                $vista = new View();
                $vista->show('competicionCreador.php', [ //mostrar vista creador competicion
                    'competicion' => $competicion,
                    'estado' => $estadoCompeticion
                ]);
            }
        } else {
            //Si no es creador
            if ($cantidadEquipos < 2) {
                //no es creador y no hay suficientes equipos
                $vista = new View();
                $vista->show('competicionEnCreacion.php', [
                    'competicion' => $competicion,
                    'estado' => $estadoCompeticion
                ]); //mostrar vista competicion sin terminar
            } else {
                //vista informacion usuarios
                $vista = new View();
                $vista->show('competicionUsuario.php', [ //mostrar vista competicion terminada
                    'competicion' => $competicion,
                    'estado' => $estadoCompeticion
                ]);
            }
        }
    }
}
