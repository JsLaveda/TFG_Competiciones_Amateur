<?php

require_once 'model/JornadaModel.php';
require_once 'model/PartidoModel.php';

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


        $competicionModel = new CompeticionModel();
        $competicion = $competicionModel->getById($id_competicion);

        if (!$competicion) {
            header('Location: index.php?controller=competicion&action=index');
            exit();
        }

        if ($competicion['estado'] === 'pendiente') {
            $vista = new View();
            $vista->show('competicionEnCreacion.php', ['competicion' => $competicion]);
            return;
        }

        $jornadaModel = new JornadaModel();
        $jornadas = $jornadaModel->getJornadasByCompeticion($id_competicion);

        $partidoModel = new PartidoModel();
        $jornadas_con_partidos = [];

        foreach ($jornadas as $jornada) {
            $partidos = $partidoModel->getPartidosByJornada($jornada['id_jornada']);
            $jornada['partidos'] = $partidos;
            $jornadas_con_partidos[] = $jornada;
        }
        $vista = new View();
        $vista->show('jornadas/listar.php', [
            'jornadas' => $jornadas_con_partidos,
            'competicion' => $competicion
        ]);
    }
}
