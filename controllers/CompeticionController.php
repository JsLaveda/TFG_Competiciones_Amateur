<?php
require_once 'models/CompeticionModel.php';
require_once 'models/EquipoModel.php';
require_once 'models/PartidoModel.php';

class CompeticionController
{
    public function crearCompeticion()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?controlador=usuario&accion=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre = trim($_POST['nombre'] ?? '');
            $fecha_inicio = trim($_POST['fecha_inicio'] ?? '');
            $fecha_fin = trim($_POST['fecha_fin'] ?? '');
            $privacidad = isset($_POST['privacidad']) ? 'Privada' : 'Publica';
            $nombre_tipo = $_POST['tipo_competicion'] ?? $_GET['tipo'] ?? 'futbol';

            // Normaliza la primera letra a mayúscula para que coincida con la tabla
            $nombre_tipo_formateado = ucfirst(strtolower($nombre_tipo));

            // Buscar el ID del tipo_competicion en la base de datos
            $db = SPDO::singleton();
            $consulta = $db->prepare("SELECT id_tipo_competicion FROM tipo_competicion WHERE nombre_competicion = ?");
            $consulta->bindParam(1, $nombre_tipo_formateado);
            $consulta->execute();
            $tipo_resultado = $consulta->fetch(PDO::FETCH_ASSOC);

            if (!$tipo_resultado) {
                die("Error: Tipo de competición no válido.");
            }

            $tipo_competicion = $tipo_resultado['id_tipo_competicion'];
            $creador = $_SESSION['usuario']['id_usuario'] ?? null;
            $estado = 'pendiente';

            // Validación
            if (empty($nombre) || empty($fecha_inicio) || empty($fecha_fin) || !$creador) {
                $params = http_build_query([
                    'error' => 'Faltan datos requeridos.',
                    'nombre' => $nombre,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_fin' => $fecha_fin,
                    'tipo' => $tipo_competicion
                ]);
                header("Location: index.php?controlador=competicion&accion=crearCompeticion&$params");
                exit();
            }

            // Crear y guardar competición
            $competicion = new CompeticionModel();
            $competicion->setNombre($nombre);
            $competicion->setFecha_inicio($fecha_inicio);
            $competicion->setFecha_fin($fecha_fin);
            $competicion->setPrivacidad($privacidad);
            $competicion->setTipo_competicion($tipo_competicion);
            $competicion->setCreador($creador);
            $competicion->setEstado($estado);

            $idCompeticion = $competicion->save();

            header("Location: index.php?controlador=equipo&accion=crearEquipo&competicion_id=" . $idCompeticion);
            exit();
        } else {
            $vista = new View();
            $vista->show('crearCompeticion.php');
        }
    }

    public function clasificacion()
{
    if (!isset($_GET['id'])) {
        echo "Error: competición no especificada";
        return;
    }

    $id = intval($_GET['id']);
    $competicionModel = new CompeticionModel();
    $competicion = $competicionModel->getById($id);

    if (!$competicion) {
        header('Location: index.php?controller=competicion&action=index');
        exit();
    }

    if ($competicion->getEstado() === 'pendiente') {
        $vista = new View();
        $vista->show('competicionEnCreacion.php', ['competicion' => $competicion]);
        return;
    }

    $competicionModel->setId_competicion($id);
    $clasificacion = $competicionModel->getClasificacion();

    $vista = new View();
    $vista->show('jornadas/listar.php', [
        'clasificacion' => $clasificacion,
        'id_competicion' => $id,
        'competicion' => $competicion  // ✅ Aquí arreglas el error
    ]);
}

    public function inicioCompeticion()
{
    session_start();

    $id = intval($_GET['id']);
    if (!$id) {
        header("Location: index.php?controlador=competicion&accion=index");
        exit();
    }

    $competicionModel = new CompeticionModel();
    $competicion = $competicionModel->getById($id);

    $usuarioId = $_SESSION['usuario']['id_usuario'] ?? null;
    if (!$usuarioId || $usuarioId != $competicion->getCreador()) {
        echo "<div class='alert alert-danger text-center mt-5'>No tienes permisos para iniciar esta competición.</div>";
        return;
    }

    // ✅ Esto es lo que activa todo correctamente
    $competicionModel->setId_competicion($id);
    $competicionModel->cambiarEstado('iniciada');

    header("Location: index.php?controlador=competicion&accion=verCompeticion&id=$id");
    exit();
}




    public function finCompeticion()
    {
        $id = intval($_GET['id']);

        $competicion = new CompeticionModel();
        $competicion->setId_competicion($id);

        // Finalizar la competición (cambiar estado y fecha)
        $competicion->cambiarEstado('finalizada');

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



    public function verCompeticion()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    $idCompeticion = $_GET['id'] ?? null;
    if (!$idCompeticion) {
        header('Location: index.php?controlador=competicion&accion=index');
        exit();
    }

    $competicionModel = new CompeticionModel();
    $competicion = $competicionModel->getById($idCompeticion);

    if (!$competicion) {
        header('Location: index.php?controlador=competicion&accion=index');
        exit();
    }

    $usuarioActual = $_SESSION['usuario'];
    $esCreador = ($usuarioActual['id_usuario'] == $competicion->getCreador());

    $equipoModel = new EquipoModel();
    $cantidadEquipos = $equipoModel->contarEquiposPorCompeticion($idCompeticion);

    $estadoCompeticion = $competicion->getEstado(); 

    $vista = new View();

    if ($esCreador) {
        if ($cantidadEquipos < 2) {
            header("Location: index.php?controlador=equipo&accion=crearEquipo&competicion_id=$idCompeticion");
            exit();
        } else {
            $vista->show('competicionCreador.php', [
                'competicion' => $competicion,
                'estado' => $estadoCompeticion
            ]);
        }
    } else {
        // Siempre redirige a la vista de usuario
        $vista->show('competicionUsuario.php', [
            'competicion' => $competicion,
            'estado' => $estadoCompeticion
        ]);
    }
}



    public function buscarCompeticion()
    {
        $datoIntroducido = $_GET['datoIntroducido'] ?? '';
        $competicion = new CompeticionModel();

        if (is_numeric($datoIntroducido)) {
            $resultado = $competicion->getById($datoIntroducido);
            $resultados = $resultado ? [$resultado] : [];
        } else {
            $resultados = $competicion->getByName($datoIntroducido);
        }

        $vista = new View();
        $vista->show(
            'resultadosBusqueda.php',
            [
                'resultados' => $resultados,
                'datoIntroducido' => $datoIntroducido
            ]
        );
    }
}
