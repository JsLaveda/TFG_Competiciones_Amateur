<?php

require_once 'model/PartidoModel.php';

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
        $partido = $partidoModel->getPartido($id_partido);

        require_once 'views/partidos/ver.php';
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
        $partido = $partidoModel->getPartido($id_partido);


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $puntuacion1 = isset($_POST['puntuacion1']) ? intval($_POST['puntuacion1']) : 0;
            $puntuacion2 = isset($_POST['puntuacion2']) ? intval($_POST['puntuacion2']) : 0;

            $partidoModel->updatePuntuacion1($id_partido, $puntuacion1);
            $partidoModel->updatePuntuacion2($id_partido, $puntuacion2);

            $id_jornada = $partido['id_jornada'];
            $id_competicion = $partidoModel->getIdCompeticionPorJornada($id_jornada);

            
            header("Location: index.php?controller=jornada&action=verJornadas&id=$id_competicion");
            exit;
        }

        require_once 'views/partidos/editarCreador.php';
    }
}
