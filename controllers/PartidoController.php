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
}
