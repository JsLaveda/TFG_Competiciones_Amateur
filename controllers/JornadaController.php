<?php

require_once 'model/JornadaModel.php';

class JornadaController
{
    public function listarJornadas()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Evitar cache 
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $id_competicion = intval($_GET['id']);

        $jornadaModel = new JornadaModel();
        $jornadas = $jornadaModel->getJornadasCompeticion($id_competicion);

        $partidoModel = new PartidoModel();

        $jornadas_con_partidos = [];

        foreach ($jornadas as $jornada) {
            $partidos = $partidoModel->getPartidosJornada($jornada['id_jornada']);
            $jornada['partidos'] = $partidos;
            $jornadas_con_partidos[] = $jornada;
        }
        require_once 'views/jornadas/listar.php';
    }
}
