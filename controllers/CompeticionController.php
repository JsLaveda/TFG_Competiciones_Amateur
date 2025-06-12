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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $fecha_inicio = $_POST['fecha_inicio'] ?: date('Y-m-d');
            $fecha_fin = $_POST['fecha_fin'] ?: date('Y-m-d', strtotime('+2 days'));
            $privacidad = isset($_POST['privacidad']) ? 1 : 0;
            $tipo_competicion = $_POST['tipo_competicion'] ?? 'futbol';
            $creador = $_SESSION['usuario']['id']; 

            $competicion = new CompeticionModel();
            $competicion->setNombre($nombre);
            $competicion->setFecha_inicio($fecha_inicio);
            $competicion->setFecha_fin($fecha_fin);
            $competicion->setPrivacidad($privacidad);
            $competicion->setTipo_competicion($tipo_competicion);
            $competicion->setCreador($creador);

            $idCompeticion = $competicion->save();
            
            header("Location: index.php?controller=equipo&action=crear&competicion_id=" . $idCompeticion);
            exit();
        } else {

            $vista = new View();
            $vista->show('crearCompeticion.php');
        }
    }

    public function clasificacion()
    {
        if (!isset($_GET['id'])) {
            echo "Error: competicion no especificada";
            return;
        }

        $id = intval($_GET['id']);

        $competicion = new CompeticionModel();
        $competicion->setId_competicion(($id));
        $clasificacion = $competicion->getClasificacion();

        $vista = new View();
        $vista->show("", ['clasificacion' => $clasificacion, 'id_competicion' => $id]);
    }
}
