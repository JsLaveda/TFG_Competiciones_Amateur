<?php

require_once 'model/PartidoModel.php';
require_once 'model/CompeticionModel.php';

class PartidoController
{
    public function verPartido()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Evitar cache 
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $id_partido = intval($_GET['id']);
        $partidoModel = new PartidoModel();
        $partido = $partidoModel->getById($id_partido);

        $competicionModel = new CompeticionModel();
        $competicion = $competicionModel->getCompeticionByPartidoId($id_partido);

        $estado = $competicion['estado'];
        $id_creador = $competicion['creador'];
        $usuario_actual = $_SESSION['usuario']['id'];

        $esCreador = ($usuario_actual == $id_creador);

        if ($esCreador && $estado !== 'finalizada') {
            $vista = new View();
            $vista->show('partidos/editarCreador.php', ['partido' => $partido]);
        } else {
            $vista = new View();
            $vista->show('partidos/ver.php', ['partido' => $partido]);
        }
    }


    public function editarPartidoCreador()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Evitar cache
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $id_partido = intval($_GET['id']);

        $partidoModel = new PartidoModel();
        $partido = $partidoModel->getById($id_partido);


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $puntuacion1 = isset($_POST['puntuacion1']) ? intval($_POST['puntuacion1']) : 0;
            $puntuacion2 = isset($_POST['puntuacion2']) ? intval($_POST['puntuacion2']) : 0;

            $partidoModel->updatePuntuacion1($id_partido, $puntuacion1);
            $partidoModel->updatePuntuacion2($id_partido, $puntuacion2);

            $id_jornada = $partido['id_jornada'];
            $id_competicion = $partidoModel->getIdCompeticionByJornada($id_jornada);


            header("Location: index.php?controller=jornada&action=verJornadas&id=$id_competicion");
            exit;
        }

        require_once 'views/partidos/editarCreador.php';
    }
}
